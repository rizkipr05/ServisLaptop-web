<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingStatusLog;
use App\Support\BookingStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    // GET /api/admin/bookings
    public function index(Request $request)
    {
        $status = $request->query('status');
        $q = $request->query('q'); // cari booking_code / nama / email

        $bookings = Booking::with(['customer', 'service', 'payment'])
            ->when($status, fn($x) => $x->where('status', $status))
            ->when($q, function ($x) use ($q) {
                $x->where('booking_code', 'like', "%{$q}%")
                  ->orWhereHas('customer', fn($c) => $c->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%"));
            })
            ->latest()
            ->paginate(15);

        return response()->json(['data' => $bookings]);
    }

    // GET /api/admin/bookings/{booking}
    public function show(Booking $booking)
    {
        return response()->json([
            'data' => $booking->load(['customer', 'service', 'payment', 'statusLogs.changer'])
        ]);
    }

    // PATCH /api/admin/bookings/{booking}/confirm
    public function confirm(Request $request, Booking $booking)
    {
        if ($booking->status !== BookingStatus::PENDING) {
            return response()->json([
                'message' => 'Only pending bookings can be confirmed'
            ], 422);
        }

        $booking->update(['status' => BookingStatus::CONFIRMED]);

        BookingStatusLog::create([
            'booking_id' => $booking->id,
            'status' => BookingStatus::CONFIRMED,
            'note' => 'Booking dikonfirmasi admin.',
            'changed_by' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Booking confirmed',
            'data' => $booking->fresh()->load(['customer','service'])
        ]);
    }

    // PATCH /api/admin/bookings/{booking}/status
    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(BookingStatus::all())],
            'note' => ['nullable','string','max:1000'],
        ]);

        $booking->update(['status' => $validated['status']]);

        BookingStatusLog::create([
            'booking_id' => $booking->id,
            'status' => $validated['status'],
            'note' => $validated['note'] ?? null,
            'changed_by' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Status updated',
            'data' => $booking->fresh()->load(['customer','service','payment'])
        ]);
    }

    // PATCH /api/admin/bookings/{booking}/price
    public function setPrice(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'estimated_cost' => ['nullable','integer','min:0'],
            'total_price' => ['required','integer','min:0'],
            'note' => ['nullable','string','max:1000'],
        ]);

        $booking->update([
            'estimated_cost' => $validated['estimated_cost'] ?? $booking->estimated_cost,
            'total_price' => $validated['total_price'],
        ]);

        // biasanya setelah set harga, status jadi diagnosed
        if ($booking->status === BookingStatus::CONFIRMED || $booking->status === BookingStatus::PENDING) {
            $booking->update(['status' => BookingStatus::DIAGNOSED]);

            BookingStatusLog::create([
                'booking_id' => $booking->id,
                'status' => BookingStatus::DIAGNOSED,
                'note' => $validated['note'] ?? 'Estimasi harga sudah dibuat.',
                'changed_by' => $request->user()->id,
            ]);
        } else {
            // log note harga tanpa ubah status (opsional)
            if (!empty($validated['note'])) {
                BookingStatusLog::create([
                    'booking_id' => $booking->id,
                    'status' => $booking->status,
                    'note' => $validated['note'],
                    'changed_by' => $request->user()->id,
                ]);
            }
        }

        return response()->json([
            'message' => 'Price updated',
            'data' => $booking->fresh()->load(['customer','service','payment','statusLogs'])
        ]);
    }
}

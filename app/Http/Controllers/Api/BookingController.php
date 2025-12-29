<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingStatusLog;
use App\Support\BookingStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    // POST /api/bookings (customer)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => ['nullable','exists:services,id'],
            'device_brand' => ['nullable','string','max:80'],
            'device_type' => ['nullable','string','max:50'],
            'serial_number' => ['nullable','string','max:80'],
            'damage_notes' => ['required','string','min:10','max:2000'],
            'scheduled_at' => ['nullable','date'],
        ]);

        $user = $request->user();

        // booking code sederhana: SV-YYYYMMDD-XXXX
        $bookingCode = 'SV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));

        $booking = Booking::create([
            'user_id' => $user->id,
            'service_id' => $validated['service_id'] ?? null,
            'booking_code' => $bookingCode,

            'device_brand' => $validated['device_brand'] ?? null,
            'device_type' => $validated['device_type'] ?? null,
            'serial_number' => $validated['serial_number'] ?? null,

            'damage_notes' => $validated['damage_notes'],
            'status' => BookingStatus::PENDING,
            'scheduled_at' => $validated['scheduled_at'] ?? null,
        ]);

        // log status awal
        BookingStatusLog::create([
            'booking_id' => $booking->id,
            'status' => BookingStatus::PENDING,
            'note' => 'Booking dibuat oleh customer.',
            'changed_by' => $user->id,
        ]);

        return response()->json([
            'message' => 'Booking created',
            'data' => $booking->load(['service'])
        ], 201);
    }

    // GET /api/bookings (customer)
    public function index(Request $request)
    {
        $bookings = Booking::with(['service', 'payment'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return response()->json(['data' => $bookings]);
    }

    // GET /api/bookings/{booking} (customer) - hanya booking miliknya
    public function show(Request $request, Booking $booking)
    {
        if ($booking->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json([
            'data' => $booking->load(['service', 'payment', 'statusLogs.changer'])
        ]);
    }

    // GET /api/tracking/{booking_code} (public/customer) - tracking by code
    public function tracking(string $bookingCode)
    {
        $booking = Booking::with(['service', 'statusLogs.changer'])
            ->where('booking_code', $bookingCode)
            ->first();

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        return response()->json([
            'data' => [
                'booking_code' => $booking->booking_code,
                'status' => $booking->status,
                'service' => $booking->service,
                'device_brand' => $booking->device_brand,
                'device_type' => $booking->device_type,
                'created_at' => $booking->created_at,
                'logs' => $booking->statusLogs,
            ]
        ]);
    }
}

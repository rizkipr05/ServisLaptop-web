<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;

class PaymentController extends Controller
{
    private function initMidtrans(): void
    {
        MidtransConfig::$serverKey = config('midtrans.server_key');
        MidtransConfig::$isProduction = (bool) config('midtrans.is_production');
        MidtransConfig::$isSanitized = (bool) config('midtrans.is_sanitized');
        MidtransConfig::$is3ds = (bool) config('midtrans.is_3ds');
    }

    // POST /api/payments/{booking}/create (customer)
    public function create(Request $request, Booking $booking)
    {
        $user = $request->user();

        if ($booking->user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // booking harus sudah punya harga
        if (!$booking->total_price || $booking->total_price <= 0) {
            return response()->json(['message' => 'Harga belum ditentukan admin'], 422);
        }

        $this->initMidtrans();

        // siapkan payment record
        $payment = Payment::firstOrCreate(
            ['booking_id' => $booking->id],
            [
                'provider' => 'midtrans',
                'amount' => (int) $booking->total_price,
                'status' => 'unpaid',
            ]
        );

        // order_id harus unik
        $orderId = $payment->provider_ref ?? ('ORDER-' . $booking->booking_code . '-' . time());

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $payment->amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ],
            'item_details' => [
                [
                    'id' => (string) ($booking->service_id ?? $booking->id),
                    'price' => (int) $payment->amount,
                    'quantity' => 1,
                    'name' => 'Service Laptop - ' . $booking->booking_code,
                ]
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        $payment->update([
            'provider_ref' => $orderId,
            'snap_token' => $snapToken,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Snap token created',
            'data' => [
                'booking_id' => $booking->id,
                'order_id' => $orderId,
                'amount' => $payment->amount,
                'snap_token' => $snapToken,
            ]
        ]);
    }

    // GET /api/payments/{booking} (customer)
    public function show(Request $request, Booking $booking)
    {
        if ($booking->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json([
            'data' => $booking->payment
        ]);
    }
}

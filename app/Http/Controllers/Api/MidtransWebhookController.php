<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class MidtransWebhookController extends Controller
{
    // POST /api/payments/webhook/midtrans
    public function handle(Request $request)
    {
        // Midtrans akan kirim JSON body
        $payload = $request->all();

        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        if (!$orderId) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        $payment = Payment::where('provider_ref', $orderId)->first();

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        // Mapping status Midtrans → status internal
        $newStatus = $payment->status;

        if ($transactionStatus === 'capture') {
            // untuk kartu kredit
            $newStatus = ($fraudStatus === 'challenge') ? 'pending' : 'paid';
        } elseif ($transactionStatus === 'settlement') {
            $newStatus = 'paid';
        } elseif ($transactionStatus === 'pending') {
            $newStatus = 'pending';
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
            $newStatus = $transactionStatus === 'expire' ? 'expired' : 'failed';
        } elseif ($transactionStatus === 'refund') {
            $newStatus = 'refunded';
        }

        $payment->status = $newStatus;
        if ($newStatus === 'paid' && !$payment->paid_at) {
            $payment->paid_at = now();
        }
        $payment->save();

        return response()->json(['message' => 'OK']);
    }
}

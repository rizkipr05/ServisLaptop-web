<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // GET /api/transactions?status=paid&q=SV-&from=2025-12-01&to=2025-12-31
    public function index(Request $request)
    {
        $user = $request->user();
        $q = $request->query('q');
        $status = $request->query('status'); // payment status: paid/pending/failed/expired/refunded/unpaid
        $from = $request->query('from');
        $to = $request->query('to');

        $perPage = (int) ($request->query('per_page', 10));
        $perPage = max(5, min(50, $perPage));

        $query = Booking::query()
            ->with([
                'service:id,name,base_price',
                'payment:id,booking_id,provider,status,amount,paid_at,provider_ref',
            ])
            ->where('user_id', $user->id)
            ->whereNotNull('total_price');

        if ($q) {
            $query->where('booking_code', 'like', "%{$q}%");
        }

        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }

        if ($status) {
            $query->whereHas('payment', fn($p) => $p->where('status', $status));
        }

        $data = $query->latest()->paginate($perPage);

        return response()->json(['data' => $data]);
    }

    // GET /api/transactions/{booking} (detail transaksi customer)
    public function show(Request $request, Booking $booking)
    {
        if ($booking->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json([
            'data' => $booking->load(['service', 'payment', 'statusLogs.changer'])
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // GET /api/admin/reports/transactions?status=paid&from=2025-12-01&to=2025-12-31
    public function transactions(Request $request)
    {
        $status = $request->query('status'); // payment status
        $from = $request->query('from');
        $to = $request->query('to');

        $perPage = (int) ($request->query('per_page', 15));
        $perPage = max(5, min(100, $perPage));

        $query = Booking::query()
            ->with([
                'customer:id,name,email,phone',
                'service:id,name',
                'payment:id,booking_id,status,amount,paid_at,provider,provider_ref',
            ])
            ->whereNotNull('total_price');

        if ($from) $query->whereDate('created_at', '>=', $from);
        if ($to) $query->whereDate('created_at', '<=', $to);

        if ($status) {
            $query->whereHas('payment', fn($p) => $p->where('status', $status));
        }

        $rows = $query->latest()->paginate($perPage);

        // Summary (omzet + total transaksi) berdasarkan filter yang sama
        $summaryQuery = clone $query;

        $totalTransactions = (clone $summaryQuery)->count();

        $totalRevenue = (clone $summaryQuery)
            ->whereHas('payment', fn($p) => $p->where('status', 'paid'))
            ->sum('total_price');

        return response()->json([
            'data' => $rows,
            'summary' => [
                'total_transactions' => $totalTransactions,
                'total_revenue_paid' => (int) $totalRevenue,
            ]
        ]);
    }
}

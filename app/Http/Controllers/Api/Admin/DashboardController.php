<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // GET /api/admin/dashboard?from=2025-12-01&to=2025-12-31
    public function index(Request $request)
    {
        $from = $request->query('from'); // optional YYYY-MM-DD
        $to   = $request->query('to');   // optional YYYY-MM-DD

        // base query booking (untuk filter tanggal)
        $bookingQuery = Booking::query()
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to));

        $totalBookings = (clone $bookingQuery)->count();

        // Booking per status
        $byStatusRaw = (clone $bookingQuery)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // rapihin supaya status yang tidak ada tetap 0
        $statusList = ['pending','confirmed','diagnosed','in_repair','ready','completed','cancelled'];
        $bookingsByStatus = [];
        foreach ($statusList as $st) {
            $bookingsByStatus[$st] = (int) ($byStatusRaw[$st] ?? 0);
        }

        // Users
        $totalUsers = User::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        // Omzet hanya dari payment.status=paid
        $paidRevenue = (clone $bookingQuery)
            ->whereHas('payment', fn($p) => $p->where('status', 'paid'))
            ->sum('total_price');

        // Total transaksi paid
        $paidTransactions = (clone $bookingQuery)
            ->whereHas('payment', fn($p) => $p->where('status', 'paid'))
            ->count();

        // Booking terbaru (preview dashboard)
        $latestBookings = (clone $bookingQuery)
            ->with(['customer:id,name,email', 'service:id,name', 'payment:id,booking_id,status,amount'])
            ->latest()
            ->limit(8)
            ->get([
                'id','booking_code','user_id','service_id','status','total_price','created_at'
            ]);

        return response()->json([
            'data' => [
                'filters' => [
                    'from' => $from,
                    'to' => $to,
                ],
                'counts' => [
                    'total_bookings' => (int) $totalBookings,
                    'total_users' => (int) $totalUsers,
                    'total_customers' => (int) $totalCustomers,
                    'total_admins' => (int) $totalAdmins,
                ],
                'bookings_by_status' => $bookingsByStatus,
                'revenue' => [
                    'paid_revenue' => (int) $paidRevenue,
                    'paid_transactions' => (int) $paidTransactions,
                ],
                'latest_bookings' => $latestBookings,
            ]
        ]);
    }
}

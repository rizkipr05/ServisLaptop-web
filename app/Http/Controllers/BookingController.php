<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class BookingController extends Controller
{
    // Tampilkan Halaman Form
    public function create()
    {
        return Inertia::render('Booking/Create', [
            // Kirim Client Key ke Frontend (Vue) buat popup Snap
            'midtrans_client_key' => config('midtrans.client_key'),
        ]);
    }

    // Proses Simpan & Request Payment
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'device_type' => 'required|string',
            'service_type' => 'required|string',
            'description' => 'required|string',
        ]);

        // Estimasi Harga (data dummy dulu)
        $prices = [
            'service_ringan' => 150000,
            'install_ulang' => 100000,
            'mati_total' => 50000, 
            'cleaning' => 75000,
        ];
        $harga = $prices[$request->service_type] ?? 0;

        // Simpan ke Database
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'device_type' => $request->device_type,
            'service_type' => $request->service_type,
            'damage_notes' => $request->description, 
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'total_price' => $harga,
        ]);

        // Setup Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Minta Token ke Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $booking->booking_code,
                'gross_amount' => $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $booking->name,
                'email' => Auth::user()->email,
                'phone' => $booking->phone,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            
            // Simpan token ke database
            $booking->update(['snap_token' => $snapToken]);

            return redirect()->back()->with('success', 'Booking berhasil! Silakan bayar.');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['msg' => 'Gagal koneksi Midtrans: ' . $e->getMessage()]);
        }

        try {
            $snapToken = Snap::getSnapToken($params);
        
            // Update token ke database
            $booking->update(['snap_token' => $snapToken]);

            // [UPDATE] Kirim snap_token ke Frontend via session flash
            return redirect()->back()->with([
                'success' => 'Booking berhasil! Silakan selesaikan pembayaran.',
                'snap_token' => $snapToken 
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['msg' => 'Gagal koneksi Midtrans: ' . $e->getMessage()]);
        }
    }
}
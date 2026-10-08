<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class OrderManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['items', 'payment.paymentMethod', 'user']);

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status') && $request->payment_status !== 'semua') {
            $query->whereHas('payment', function($q) use ($request) {
                $q->where('status', $request->payment_status);
            });
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_phone', 'like', '%' . $request->search . '%');
            });
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.order-management.index', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,delivered,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Status pesanan berhasil diperbarui');
    }

    public function approvePayment(Payment $payment)
    {
        if ($payment->status !== 'waiting_verification') {
            return back()->with('error', 'Hanya pembayaran dengan status menunggu verifikasi yang bisa disetujui');
        }

        $payment->update([
            'status' => 'paid',
            'verified_by' => auth('admin')->id(),
            'verified_at' => now(),
        ]);

        $payment->order->update(['status' => 'confirmed']);

        return response()->json(['success' => true, 'message' => 'Pembayaran berhasil disetujui']);
    }

    public function rejectPayment(Request $request, Payment $payment)
    {
        if ($payment->status !== 'waiting_verification') {
            return response()->json(['success' => false, 'message' => 'Hanya pembayaran dengan status menunggu verifikasi yang bisa ditolak'], 422);
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $payment->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'verified_by' => auth('admin')->id(),
            'verified_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Pembayaran berhasil ditolak']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'Keranjang kosong');
        }

        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $id => $item) {
            $menu = Menu::find($id);
            if ($menu && $menu->available) {
                $cartItems[] = [
                    'menu' => $menu,
                    'quantity' => $item['quantity'],
                    'subtotal' => $menu->price * $item['quantity'],
                ];
                $subtotal += $menu->price * $item['quantity'];
            }
        }

        if (empty($cartItems)) {
            return redirect()->route('menu.index')->with('error', 'Menu tidak tersedia');
        }

        return view('orders.checkout', compact('cartItems', 'subtotal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|max:20',
            'delivery_method' => 'required|in:pickup,delivery',
            'delivery_address' => 'required_if:delivery_method,delivery|nullable|max:500',
            'latitude' => 'required_if:delivery_method,delivery|nullable|numeric',
            'longitude' => 'required_if:delivery_method,delivery|nullable|numeric',
            'notes' => 'nullable|max:500',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong');
        }

        DB::beginTransaction();
        try {
            $subtotal = 0;
            $orderItems = [];

            foreach ($cart as $menuId => $item) {
                $menu = Menu::find($menuId);
                if (!$menu || !$menu->available) {
                    DB::rollBack();
                    return back()->with('error', 'Menu tidak tersedia: ' . ($menu->name ?? 'Unknown'));
                }

                $itemSubtotal = $menu->price * $item['quantity'];
                $subtotal += $itemSubtotal;

                $orderItems[] = [
                    'menu_id' => $menu->id,
                    'menu_name' => $menu->name,
                    'menu_price' => $menu->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $itemSubtotal,
                ];

                $menu->increment('order_count', $item['quantity']);
            }

            $deliveryFee = $validated['delivery_method'] === 'delivery' ? 10000 : 0;
            $total = $subtotal + $deliveryFee;

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => Order::generateOrderNumber(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'delivery_method' => $validated['delivery_method'],
                'delivery_address' => $validated['delivery_address'] ?? null,
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
                'status' => 'pending',
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }

            session()->forget('cart');

            DB::commit();

            return redirect()->route('orders.success', $order->id)->with('success', 'Pesanan berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function success($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('orders.success', compact('order'));
    }

    public function history()
    {
        $orders = auth()->user()->orders()->with('payment')->latest()->paginate(10);
        return view('orders.history', compact('orders'));
    }

    public function show($id)
    {
        $order = auth()->user()->orders()->with('items', 'payment.paymentMethod')->findOrFail($id);
        return view('orders.show', compact('order'));
    }
}

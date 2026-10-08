@extends('layouts.app')

@section('title', 'Checkout - Padang Rice')

@section('content')
<x-hero title="CHECKOUT" />

<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded mb-6">{{ session('error') }}</div>
        @endif

        <form action="{{ route('orders.store') }}" method="POST" onsubmit="return confirm('Konfirmasi pesanan Anda?')">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h2 class="text-xl font-bold mb-4">Informasi Pemesan</h2>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Nama</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}" required class="w-full px-4 py-2 border rounded @error('customer_name') border-red-500 @enderror">
                        @error('customer_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">No. Telepon</label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required class="w-full px-4 py-2 border rounded @error('customer_phone') border-red-500 @enderror">
                        @error('customer_phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Tipe Pesanan</label>
                        <select name="order_type" id="order_type" required class="w-full px-4 py-2 border rounded">
                            <option value="pickup" {{ old('order_type') === 'pickup' ? 'selected' : '' }}>Ambil Sendiri</option>
                            <option value="delivery" {{ old('order_type') === 'delivery' ? 'selected' : '' }}>Delivery</option>
                        </select>
                    </div>
                    <div class="mb-4" id="delivery_address_field" style="display:none;">
                        <label class="block text-sm font-medium mb-2">Alamat Pengantaran</label>
                        <textarea name="delivery_address" rows="3" class="w-full px-4 py-2 border rounded">{{ old('delivery_address') }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Catatan (opsional)</label>
                        <textarea name="note" rows="2" class="w-full px-4 py-2 border rounded">{{ old('note') }}</textarea>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-bold mb-4">Ringkasan Pesanan</h2>
                    <div class="space-y-2 mb-4">
                        @foreach($cartItems as $item)
                        <div class="flex justify-between text-sm">
                            <span>{{ $item['menu']->name }} x{{ $item['quantity'] }}</span>
                            <span>{{ 'Rp ' . number_format($item['subtotal'], 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="border-t pt-4 space-y-2">
                        <div class="flex justify-between"><span>Subtotal</span><span>{{ 'Rp ' . number_format($subtotal, 0, ',', '.') }}</span></div>
                        <div class="flex justify-between" id="delivery_fee_row" style="display:none;"><span>Biaya Delivery</span><span>Rp 10.000</span></div>
                        <div class="flex justify-between font-bold text-lg border-t pt-2"><span>Total</span><span id="total_price">{{ 'Rp ' . number_format($subtotal, 0, ',', '.') }}</span></div>
                    </div>
                    <button type="submit" class="w-full mt-6 px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800">Pesan Sekarang</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
document.getElementById('order_type').addEventListener('change', function() {
    const isDelivery = this.value === 'delivery';
    document.getElementById('delivery_address_field').style.display = isDelivery ? 'block' : 'none';
    document.getElementById('delivery_fee_row').style.display = isDelivery ? 'flex' : 'none';
    const subtotal = {{ $subtotal }};
    const total = isDelivery ? subtotal + 10000 : subtotal;
    document.getElementById('total_price').textContent = 'Rp ' + total.toLocaleString('id-ID');
});
</script>
@endsection

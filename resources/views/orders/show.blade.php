@extends('layouts.app')

@section('title', 'Detail Pesanan - ' . $order->order_number)

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('orders.history') }}" class="text-gray-600 hover:text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Riwayat
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Nomor Pesanan</p>
                        <p class="text-2xl font-bold">{{ $order->order_number }}</p>
                    </div>
                    <span class="px-4 py-2 rounded-full text-sm font-semibold bg-white/20">
                        {{ $order->statusLabel }}
                    </span>
                </div>
            </div>

            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600 mb-2">INFORMASI PEMESAN</h3>
                        <div class="space-y-2">
                            <p class="text-gray-800"><strong>{{ $order->customer_name }}</strong></p>
                            <p class="text-gray-600">{{ $order->customer_phone }}</p>
                            <p class="text-gray-600">{{ $order->customer_email }}</p>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600 mb-2">PENGIRIMAN</h3>
                        <div class="space-y-2">
                            <p class="text-gray-800 font-semibold">
                                {{ $order->delivery_method === 'delivery' ? 'Diantar' : 'Ambil Sendiri' }}
                            </p>
                            @if($order->delivery_method === 'delivery')
                                <p class="text-gray-600">{{ $order->delivery_address }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-gray-600 mb-4">DETAIL PESANAN</h3>
                    <div class="border rounded-xl overflow-hidden">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left px-4 py-3 text-sm font-semibold text-gray-600">Menu</th>
                                    <th class="text-center px-4 py-3 text-sm font-semibold text-gray-600">Qty</th>
                                    <th class="text-right px-4 py-3 text-sm font-semibold text-gray-600">Harga</th>
                                    <th class="text-right px-4 py-3 text-sm font-semibold text-gray-600">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="px-4 py-3 text-gray-800">{{ $item->menu_name }}</td>
                                        <td class="px-4 py-3 text-center text-gray-600">{{ $item->quantity }}</td>
                                        <td class="px-4 py-3 text-right text-gray-600">{{ $item->formattedPrice }}</td>
                                        <td class="px-4 py-3 text-right font-semibold text-gray-800">{{ $item->formattedSubtotal }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-6">
                    <div class="space-y-2">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>{{ $order->formattedSubtotal }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Ongkir</span>
                            <span>{{ $order->formattedDeliveryFee }}</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold text-gray-800 pt-2 border-t">
                            <span>Total</span>
                            <span>{{ $order->formattedTotal }}</span>
                        </div>
                    </div>
                </div>

                @if($order->notes)
                    <div class="mt-6 p-4 bg-yellow-50 rounded-xl">
                        <p class="text-sm font-semibold text-gray-600 mb-1">Catatan:</p>
                        <p class="text-gray-800">{{ $order->notes }}</p>
                    </div>
                @endif

                @if($order->payment)
                    <div class="mt-8 p-6 {{ $order->payment->status === 'paid' ? 'bg-green-50' : ($order->payment->status === 'rejected' ? 'bg-red-50' : 'bg-yellow-50') }} rounded-xl">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-gray-900">Status Pembayaran</h3>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $order->payment->statusColor }}">
                                {{ $order->payment->statusLabel }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-700 mb-3">Metode: {{ $order->payment->paymentMethod->name }}</p>
                        
                        @if($order->payment->status === 'unpaid')
                            <a href="{{ route('payments.upload', $order) }}" 
                               class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                                Upload Bukti Pembayaran
                            </a>
                        @elseif($order->payment->status === 'waiting_verification')
                            <p class="text-sm text-gray-700">Bukti pembayaran sedang diverifikasi admin.</p>
                        @elseif($order->payment->status === 'rejected')
                            <p class="text-sm text-red-700 mb-3">{{ $order->payment->rejection_reason }}</p>
                            <a href="{{ route('payments.upload', $order) }}" 
                               class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                                Upload Ulang Bukti
                            </a>
                        @elseif($order->payment->status === 'paid')
                            <p class="text-sm text-green-700">Pembayaran telah dikonfirmasi.</p>
                        @endif
                    </div>
                @else
                    <div class="mt-8 p-6 bg-blue-50 rounded-xl">
                        <h3 class="font-bold text-blue-900 mb-2">Belum Ada Pembayaran</h3>
                        <p class="text-blue-800 mb-4">Silakan pilih metode pembayaran untuk melanjutkan:</p>
                        <a href="{{ route('payments.show', $order) }}" 
                           class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                            Pilih Metode Pembayaran
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Pilih Metode Pembayaran - Padang Rice')

@section('content')
<div class="min-h-screen bg-[#f5f4f1] pt-20 pb-16">
    <div class="max-w-2xl mx-auto px-4">
        <div class="py-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 font-display">Pilih Metode Pembayaran</h1>
            <p class="text-gray-600 mt-2">Order #{{ $order->order_number }}</p>
        </div>

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-3 mb-6 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <h2 class="font-bold text-gray-900 text-lg mb-4">Total Pembayaran</h2>
            <p class="text-4xl font-bold text-yellow-600">{{ $order->formattedTotal }}</p>
        </div>

        <form action="{{ route('payments.store', $order) }}" method="POST">
            @csrf
            
            <div class="space-y-3 mb-6">
                @forelse($paymentMethods as $method)
                    <label class="block cursor-pointer">
                        <input type="radio" name="payment_method_id" value="{{ $method->id }}" 
                               class="peer sr-only" required>
                        <div class="bg-white border-2 border-gray-200 peer-checked:border-yellow-500 peer-checked:bg-yellow-50 rounded-xl p-4 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $method->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $method->typeLabel }}</p>
                                    </div>
                                </div>
                                <div class="w-6 h-6 rounded-full border-2 peer-checked:border-yellow-500 peer-checked:bg-yellow-500 border-gray-300 flex items-center justify-center transition-all">
                                    <svg class="w-4 h-4 text-white hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </label>
                @empty
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
                        <p class="text-yellow-800">Belum ada metode pembayaran aktif</p>
                    </div>
                @endforelse
            </div>

            @if($paymentMethods->isNotEmpty())
                <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-4 rounded-xl transition">
                    Lanjutkan
                </button>
            @endif
        </form>
    </div>
</div>

<script>
// Add visual feedback for radio selection
document.querySelectorAll('input[type="radio"][name="payment_method_id"]').forEach(radio => {
    radio.addEventListener('change', function() {
        // Remove all checked styles
        document.querySelectorAll('input[type="radio"][name="payment_method_id"]').forEach(r => {
            const parent = r.closest('label').querySelector('div');
            parent.classList.remove('border-yellow-500', 'bg-yellow-50');
            parent.classList.add('border-gray-200', 'bg-white');
        });
        
        // Add checked style to selected
        const parent = this.closest('label').querySelector('div');
        parent.classList.remove('border-gray-200', 'bg-white');
        parent.classList.add('border-yellow-500', 'bg-yellow-50');
    });
});
</script>
@endsection

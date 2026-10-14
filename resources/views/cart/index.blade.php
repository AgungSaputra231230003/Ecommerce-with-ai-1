@extends('layouts.app')

@section('content')
    @if (session('checkout_receipt'))
        @php($receipt = session('checkout_receipt'))
        <div data-receipt-modal class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/75 p-4 backdrop-blur-sm">
            <div class="w-full max-w-lg rounded-[2rem] border border-emerald-500/30 bg-slate-900 p-6 shadow-2xl shadow-emerald-900/30">
                <div class="mb-5 flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.25em] text-emerald-300">Receipt</p>
                        <h2 class="mt-2 text-2xl font-black text-white">Payment successful</h2>
                    </div>
                    <button type="button" data-close-receipt class="rounded-full border border-white/10 bg-white/5 px-3 py-2 text-xs font-bold uppercase tracking-[0.15em] text-slate-200">Close</button>
                </div>

                <div class="rounded-[1.5rem] border border-white/10 bg-slate-950/60 p-4">
                    <div class="mb-4 flex items-center justify-between text-sm text-slate-300">
                        <span>Invoice</span>
                        <span class="font-bold text-white">{{ $receipt['invoice'] }}</span>
                    </div>
                    <div class="mb-4 flex items-center justify-between text-sm text-slate-300">
                        <span>Date</span>
                        <span class="font-bold text-white">{{ $receipt['date'] }}</span>
                    </div>

                    <div class="space-y-3 border-y border-white/10 py-4">
                        @foreach ($receipt['items'] as $item)
                            <div class="flex items-center justify-between gap-4 text-sm text-slate-200">
                                <div>
                                    <p class="font-semibold text-white">{{ $item['title'] }}</p>
                                    <p class="text-xs text-slate-400">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                </div>
                                <span class="font-semibold text-white">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 flex items-center justify-between text-lg font-black text-white">
                        <span>Total</span>
                        <span>Rp {{ number_format($receipt['total'], 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const modal = document.querySelector('[data-receipt-modal]');
                const closeButton = document.querySelector('[data-close-receipt]');

                if (!modal) {
                    return;
                }

                const closeModal = () => modal.remove();

                closeButton?.addEventListener('click', closeModal);
                modal.addEventListener('click', (event) => {
                    if (event.target === modal) {
                        closeModal();
                    }
                });
            });
        </script>
    @endif

    <div class="grid gap-8 lg:grid-cols-[1.25fr_0.75fr]">
        <div class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6 shadow-xl shadow-slate-950/30">
            <div class="mb-6 flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.25em] text-violet-300">Shopping cart</p>
                    <h1 class="mt-2 text-3xl font-black text-white">Your items</h1>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('history') }}" class="rounded-full border border-emerald-500/40 bg-emerald-500/10 px-3 py-2 text-[10px] font-bold uppercase tracking-[0.15em] text-emerald-200 transition hover:bg-emerald-500/20">
                        History
                    </a>
                    <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-3 py-2 text-xs font-bold uppercase tracking-[0.15em] text-slate-200 transition hover:bg-white/10">
                        Continue shopping
                    </a>
                </div>
            </div>

            @if (count($items) > 0)
                <div class="space-y-4">
                    @foreach ($items as $item)
                        <div class="flex flex-col gap-4 rounded-[1.5rem] border border-white/10 bg-slate-950/60 p-4 md:flex-row md:items-center md:justify-between">
                            <div class="flex items-center gap-4">
                                <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->title }}" class="h-20 w-20 rounded-2xl object-cover" />
                                <div>
                                    <h2 class="text-lg font-bold text-white">{{ $item['product']->title }}</h2>
                                    <p class="text-sm text-slate-400">Rp {{ number_format($item['product']->price, 0, ',', '.') }} each</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <form method="POST" action="{{ route('cart.update', $item['product']) }}">
                                    @csrf
                                    <div class="flex items-center gap-2 rounded-full border border-white/10 bg-slate-900 px-2 py-1">
                                        <label class="text-xs uppercase tracking-[0.2em] text-slate-500">Qty</label>
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-16 bg-transparent text-center text-sm text-white outline-none" />
                                        <button type="submit" class="rounded-full bg-violet-500/15 px-2 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-violet-200">Update</button>
                                    </div>
                                </form>

                                <form method="POST" action="{{ route('cart.remove', $item['product']) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-full border border-red-500/40 bg-red-500/10 px-3 py-2 text-[10px] font-bold uppercase tracking-[0.2em] text-red-200">Remove</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-[1.5rem] border border-dashed border-white/15 bg-slate-950/40 p-12 text-center text-slate-300">
                    Your cart is empty right now.
                </div>
            @endif
        </div>

        <aside class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6 shadow-xl shadow-slate-950/30">
            <p class="text-xs font-bold uppercase tracking-[0.25em] text-emerald-300">Order summary</p>
            <h2 class="mt-3 text-2xl font-black text-white">Checkout</h2>

            <div class="mt-6 space-y-3 text-sm text-slate-300">
                @foreach ($items as $item)
                    <div class="flex items-center justify-between">
                        <span>{{ $item['product']->title }} x {{ $item['quantity'] }}</span>
                        <span>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 border-t border-white/10 pt-4">
                <div class="flex items-center justify-between text-lg font-black text-white">
                    <span>Total</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('checkout') }}">
                @csrf
                <button type="submit" class="mt-6 w-full rounded-2xl bg-gradient-to-r from-emerald-500 via-cyan-500 to-blue-500 px-4 py-3 text-sm font-bold uppercase tracking-[0.15em] text-white shadow-lg shadow-emerald-500/20 transition hover:brightness-110">
                    Simulate checkout
                </button>
            </form>
        </aside>
    </div>
@endsection

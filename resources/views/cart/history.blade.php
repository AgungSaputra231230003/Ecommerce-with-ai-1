@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between gap-4 rounded-[2rem] border border-white/10 bg-slate-900/70 p-6 shadow-xl shadow-slate-950/30">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.25em] text-violet-300">Purchase history</p>
                <h1 class="mt-2 text-3xl font-black text-white">Riwayat pembelian</h1>
            </div>
            <a href="{{ route('cart') }}" class="rounded-full border border-white/10 bg-white/5 px-3 py-2 text-xs font-bold uppercase tracking-[0.15em] text-slate-200 transition hover:bg-white/10">
                Back to cart
            </a>
        </div>

        @if ($histories->isEmpty())
            <div class="rounded-[2rem] border border-dashed border-white/15 bg-slate-900/50 p-12 text-center text-slate-300">
                Belum ada riwayat pembelian.
            </div>
        @else
            <div class="space-y-4">
                @foreach ($histories as $history)
                    <div class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-5 shadow-xl shadow-slate-950/30">
                        <div class="mb-4 flex flex-col gap-3 border-b border-white/10 pb-4 md:flex-row md:items-center md:justify-between">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-300">Invoice</p>
                                <h2 class="mt-1 text-xl font-black text-white">{{ $history->invoice }}</h2>
                            </div>
                            <div class="text-left md:text-right">
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Tanggal</p>
                                <p class="mt-1 text-sm font-semibold text-slate-200">{{ $history->purchase_date->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @foreach ($history->items as $item)
                                <div class="flex items-center justify-between gap-4 rounded-2xl border border-white/10 bg-slate-950/50 px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        @if (!empty($item['image_url']))
                                            <img src="{{ $item['image_url'] }}" alt="{{ $item['title'] }}" class="h-14 w-14 rounded-xl object-cover" />
                                        @endif
                                        <div>
                                            <p class="font-semibold text-white">{{ $item['title'] }}</p>
                                            <p class="text-xs text-slate-400">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <span class="font-bold text-white">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-5 flex items-center justify-between border-t border-white/10 pt-4 text-lg font-black text-white">
                            <span>Total</span>
                            <span>Rp {{ number_format($history->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

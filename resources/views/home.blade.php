@extends('layouts.app')

@section('content')
    <section class="mb-10 overflow-hidden rounded-[2rem] border border-white/10 bg-slate-900/70 shadow-2xl shadow-fuchsia-950/30">
        <div class="grid gap-8 p-6 md:grid-cols-[1.3fr_0.7fr] md:p-10">
            <div class="space-y-6">
                <span class="inline-flex rounded-full border border-fuchsia-500/40 bg-fuchsia-500/10 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.25em] text-fuchsia-200">Fresh drop</span>
                <h1 class="max-w-xl text-4xl font-black tracking-tight text-white md:text-6xl">Level up your vibe with curated essentials.</h1>
                <p class="max-w-xl text-base text-slate-300">Discover limited-edition skincare, accessories, gadgets, and streetwear built for expressive lifestyles.</p>

                <div class="flex flex-wrap gap-3">
                    <a href="#products" class="rounded-full bg-gradient-to-r from-pink-500 via-violet-500 to-cyan-500 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-violet-500/30 transition hover:brightness-110">Shop now</a>
                    <a href="{{ route('register') }}" class="rounded-full border border-white/10 bg-white/5 px-5 py-3 text-sm font-bold text-slate-100 transition hover:bg-white/10">Join the club</a>
                </div>
            </div>

            <div class="rounded-[2rem] border border-white/10 bg-gradient-to-br from-violet-500/25 via-slate-900 to-cyan-500/10 p-4">
                <img src="https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=900&q=80" alt="featured product" class="h-full min-h-[280px] w-full rounded-[1.5rem] object-cover" />
            </div>
        </div>
    </section>

    <section class="mb-8">
        <div class="flex flex-col gap-5 rounded-[2rem] border border-white/10 bg-slate-900/70 p-5 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Browse by category</p>
                <h2 class="mt-2 text-2xl font-black text-white">Find your next favorite</h2>
            </div>

            <form id="product-filter-form" data-ajax-form="true" data-ajax-target="#products" method="GET" class="flex flex-col gap-3 md:flex-row">
                <select id="category-filter" name="category" data-ajax-trigger="change" class="rounded-full border border-white/10 bg-slate-950 px-4 py-3 text-sm text-slate-100 focus:border-fuchsia-500 focus:outline-none">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>

                <input id="search-filter" type="text" name="search" value="{{ request('search') }}" placeholder="Search product..." class="rounded-full border border-white/10 bg-slate-950 px-4 py-3 text-sm text-slate-100 placeholder:text-slate-500 focus:border-fuchsia-500 focus:outline-none" />

                <button type="submit" class="rounded-full bg-gradient-to-r from-fuchsia-500 to-violet-500 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-fuchsia-500/20 transition hover:brightness-110">
                    Filter
                </button>
            </form>
        </div>
    </section>

    <section id="products" class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($products as $product)
            <article class="group overflow-hidden rounded-[2rem] border border-white/10 bg-slate-900/70 transition duration-300 hover:-translate-y-1 hover:border-fuchsia-500/50 hover:shadow-2xl hover:shadow-fuchsia-900/25">
                <div class="relative overflow-hidden">
                    <img src="{{ $product->image_url }}" alt="{{ $product->title }}" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105" />
                    <span class="absolute left-4 top-4 rounded-full border border-white/10 bg-slate-950/70 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-200">
                        {{ $product->category?->name ?? 'Featured' }}
                    </span>
                </div>

                <div class="space-y-4 p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-xl font-black text-white">{{ $product->title }}</h3>
                            <p class="mt-1 text-xs uppercase tracking-[0.2em] text-slate-400">{{ $product->stock }} in stock</p>
                        </div>
                        <span class="rounded-full bg-emerald-500/10 px-2 py-1 text-xs font-bold text-emerald-300">New</span>
                    </div>

                    <p class="text-sm leading-6 text-slate-300">{{ $product->description }}</p>

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Price</p>
                            <p class="text-2xl font-black text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>

                        <form method="POST" action="{{ route('cart.add', $product) }}" data-cart-submit="true">
                            @csrf
                            <button type="submit" class="rounded-full bg-gradient-to-r from-violet-500 to-pink-500 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-violet-500/20 transition hover:brightness-110">
                                Add to cart
                            </button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-[2rem] border border-dashed border-white/15 bg-slate-900/50 p-12 text-center text-slate-300">
                No products matched your filter yet.
            </div>
        @endforelse
    </section>
@endsection

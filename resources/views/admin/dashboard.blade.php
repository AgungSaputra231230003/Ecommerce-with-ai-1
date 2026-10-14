@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.25em] text-cyan-300">Admin Studio</p>
                <h1 class="mt-2 text-3xl font-black text-white">Dashboard overview</h1>
            </div>
            <a href="{{ route('home') }}" target="_blank" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-bold uppercase tracking-[0.15em] text-slate-200 transition hover:bg-white/10">
                Storefront
            </a>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-[1.5rem] border border-white/10 bg-slate-900/70 p-5">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Products</p>
                <p class="mt-4 text-3xl font-black text-white">{{ $stats['products'] }}</p>
            </div>
            <div class="rounded-[1.5rem] border border-white/10 bg-slate-900/70 p-5">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Categories</p>
                <p class="mt-4 text-3xl font-black text-white">{{ $stats['categories'] }}</p>
            </div>
            <div class="rounded-[1.5rem] border border-white/10 bg-slate-900/70 p-5">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Customers</p>
                <p class="mt-4 text-3xl font-black text-white">{{ $stats['customers'] }}</p>
            </div>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <section class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6">
                <div class="mb-5 flex items-center justify-between">
                    <h2 class="text-xl font-black text-white">Add category</h2>
                </div>

                <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-200">Category name</label>
                        <input type="text" name="name" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white focus:border-cyan-500 focus:outline-none" placeholder="Streetwear" required />
                    </div>
                    <button type="submit" class="rounded-full bg-gradient-to-r from-cyan-500 to-blue-500 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-cyan-600/20 transition hover:brightness-110">
                        Save category
                    </button>
                </form>

                <div class="mt-8 space-y-3">
                    @foreach ($categories as $category)
                        <div class="flex items-center justify-between rounded-2xl border border-white/10 bg-slate-950/60 p-3">
                            <div>
                                <p class="font-semibold text-white">{{ $category->name }}</p>
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">{{ $category->products_count }} items</p>
                            </div>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-full border border-red-500/40 bg-red-500/10 px-3 py-2 text-[10px] font-bold uppercase tracking-[0.2em] text-red-200">Delete</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6">
                <div class="mb-5 flex items-center justify-between">
                    <h2 class="text-xl font-black text-white">Add product</h2>
                </div>

                <form method="POST" action="{{ route('admin.products.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-200">Category</label>
                        <select name="category_id" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white focus:border-fuchsia-500 focus:outline-none" required>
                            <option value="">Select category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-200">Title</label>
                        <input type="text" name="title" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white focus:border-fuchsia-500 focus:outline-none" required />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-200">Description</label>
                        <textarea name="description" rows="3" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white focus:border-fuchsia-500 focus:outline-none"></textarea>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-200">Price</label>
                            <input type="number" name="price" min="0" step="1000" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white focus:border-fuchsia-500 focus:outline-none" required />
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-200">Stock</label>
                            <input type="number" name="stock" min="0" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white focus:border-fuchsia-500 focus:outline-none" required />
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-200">Image URL</label>
                        <input type="url" name="image_url" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white focus:border-fuchsia-500 focus:outline-none" required />
                    </div>

                    <button type="submit" class="rounded-full bg-gradient-to-r from-fuchsia-500 via-violet-500 to-pink-500 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-fuchsia-500/20 transition hover:brightness-110">
                        Save product
                    </button>
                </form>
            </section>
        </div>

        <section class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6">
            <div class="mb-5 flex items-center justify-between">
                <h2 class="text-xl font-black text-white">Catalog</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm text-slate-300">
                    <thead>
                        <tr class="border-b border-white/10 text-xs uppercase tracking-[0.2em] text-slate-500">
                            <th class="pb-3 pr-4">Product</th>
                            <th class="pb-3 pr-4">Category</th>
                            <th class="pb-3 pr-4">Price</th>
                            <th class="pb-3 pr-4">Stock</th>
                            <th class="pb-3 pr-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr class="border-b border-white/5 align-middle">
                                <td class="py-3 pr-4 text-white">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->title }}" class="h-12 w-12 rounded-xl object-cover" />
                                        <span class="font-semibold">{{ $product->title }}</span>
                                    </div>
                                </td>
                                <td class="py-3 pr-4">{{ $product->category?->name ?? 'Uncategorized' }}</td>
                                <td class="py-3 pr-4">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="py-3 pr-4">{{ $product->stock }}</td>
                                <td class="py-3 pr-4">
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-full border border-red-500/40 bg-red-500/10 px-3 py-2 text-[10px] font-bold uppercase tracking-[0.2em] text-red-200">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6">
            <div class="mb-5 flex items-center justify-between">
                <h2 class="text-xl font-black text-white">Customer list</h2>
            </div>

            <div class="space-y-3">
                @foreach ($customers as $customer)
                    <div class="flex items-center justify-between rounded-2xl border border-white/10 bg-slate-950/60 p-4">
                        <div>
                            <p class="font-semibold text-white">{{ $customer->name }}</p>
                            <p class="text-sm text-slate-400">{{ $customer->email }}</p>
                        </div>
                        <form method="POST" action="{{ route('admin.customers.promote', $customer) }}">
                            @csrf
                            <button type="submit" class="rounded-full bg-gradient-to-r from-emerald-500 to-cyan-500 px-4 py-2 text-xs font-bold uppercase tracking-[0.15em] text-white shadow-lg shadow-emerald-500/20 transition hover:brightness-110">
                                Promote to admin
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection

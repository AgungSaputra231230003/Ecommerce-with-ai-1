<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-950 text-slate-100 antialiased">
        <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(236,72,153,0.22),transparent_28%),radial-gradient(circle_at_bottom_right,_rgba(59,130,246,0.18),transparent_25%)]">
            <header class="sticky top-0 z-30 border-b border-white/10 bg-slate-950/80 backdrop-blur-xl">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-fuchsia-500 via-violet-500 to-cyan-400 text-lg font-black shadow-lg shadow-fuchsia-500/30">N</div>
                        <div>
                            <p class="text-lg font-black tracking-tight text-white">NovaCart</p>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400">Gen-Z store</p>
                        </div>
                    </a>

                    <nav class="hidden items-center gap-6 md:flex">
                        <a href="{{ route('home') }}" class="text-sm font-medium text-slate-300 transition hover:text-white">Home</a>
                        <a href="#products" class="text-sm font-medium text-slate-300 transition hover:text-white">Products</a>
                        <a href="{{ route('cart') }}" class="text-sm font-medium text-slate-300 transition hover:text-white">Cart</a>
                        @auth
                            <a href="{{ route('history') }}" class="text-sm font-medium text-slate-300 transition hover:text-white">History</a>
                        @endauth
                    </nav>

                    <div class="flex items-center gap-3">
                        @auth
                            <div class="hidden items-center gap-2 sm:flex">
                                <span class="text-sm font-semibold text-white">{{ Auth::user()->name }}</span>
                                @if (Auth::user()->isAdmin())
                                    <span class="rounded-full border border-cyan-400/60 bg-cyan-500/10 px-2 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-cyan-300">[Admin]</span>
                                @endif
                            </div>

                            @if (Auth::user()->isAdmin())
                                <a href="{{ route('admin') }}" target="_blank" class="hidden rounded-full border border-cyan-400/50 bg-cyan-500/10 px-3 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-cyan-200 transition hover:bg-cyan-500/20 sm:inline-flex">
                                    Admin Studio
                                </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="rounded-full border border-white/10 bg-white/5 px-3 py-2 text-xs font-semibold uppercase tracking-[0.15em] text-slate-200 transition hover:bg-white/10">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="rounded-full border border-white/10 bg-white/5 px-3 py-2 text-xs font-semibold uppercase tracking-[0.15em] text-slate-200 transition hover:bg-white/10">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="rounded-full bg-gradient-to-r from-pink-500 via-violet-500 to-cyan-500 px-3 py-2 text-xs font-semibold uppercase tracking-[0.15em] text-white shadow-lg shadow-violet-500/30 transition hover:brightness-110">
                                Register
                            </a>
                        @endauth

                        <a href="{{ route('cart') }}" class="relative inline-flex items-center justify-center rounded-full border border-white/10 bg-white/5 p-2 text-slate-200 transition hover:bg-white/10">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.5l2.4 10.5a1.5 1.5 0 001.47 1.2h8.79a1.5 1.5 0 001.47-1.2L18.75 6H5.4M9 18.75A1.125 1.125 0 1 0 9 16.5a1.125 1.125 0 0 0 0 2.25ZM17.25 18.75A1.125 1.125 0 1 0 17.25 16.5a1.125 1.125 0 0 0 0 2.25Z"/>
                            </svg>
                            <span data-cart-count class="absolute -right-1 -top-1 inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-pink-500 px-1 text-[10px] font-bold text-white">
                                {{ array_sum(session('cart', [])) }}
                            </span>
                        </a>
                    </div>
                </div>
            </header>

            <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-2xl border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

        <button
            type="button"
            data-scroll-top
            class="fixed bottom-6 right-6 z-40 hidden rounded-full bg-gradient-to-r from-fuchsia-500 via-violet-500 to-cyan-500 p-3 text-white shadow-lg shadow-fuchsia-500/30 transition-all duration-300 hover:scale-105"
            aria-label="Scroll to top"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5m0 0 5 5m-5-5-5 5"/>
            </svg>
        </button>
    </body>
</html>

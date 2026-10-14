@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-md rounded-[2rem] border border-white/10 bg-slate-900/80 p-8 shadow-2xl shadow-slate-950/40">
        <div class="mb-8 text-center">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-fuchsia-300">Welcome back</p>
            <h1 class="mt-3 text-3xl font-black text-white">Login to NovaCart</h1>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-slate-200">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white placeholder:text-slate-500 focus:border-fuchsia-500 focus:outline-none" placeholder="you@example.com" />
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-slate-200">Password</label>
                <input id="password" name="password" type="password" required class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white placeholder:text-slate-500 focus:border-fuchsia-500 focus:outline-none" placeholder="••••••••" />
            </div>

            <div class="flex items-center justify-between text-sm text-slate-300">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="remember" class="h-4 w-4 rounded border-white/10 bg-slate-950 text-fuchsia-500" />
                    Remember me
                </label>
                <a href="{{ route('home') }}" class="text-fuchsia-300 hover:text-fuchsia-200">Back to store</a>
            </div>

            <button type="submit" class="w-full rounded-2xl bg-gradient-to-r from-fuchsia-500 via-violet-500 to-cyan-500 px-4 py-3 text-sm font-bold uppercase tracking-[0.15em] text-white shadow-lg shadow-violet-500/30 transition hover:brightness-110">
                Login
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-400">
            Need an account?
            <a href="{{ route('register') }}" class="font-semibold text-fuchsia-300 hover:text-fuchsia-200">Register here</a>
        </p>
    </div>
@endsection

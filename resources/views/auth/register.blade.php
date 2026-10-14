@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-md rounded-[2rem] border border-white/10 bg-slate-900/80 p-8 shadow-2xl shadow-slate-950/40">
        <div class="mb-8 text-center">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-cyan-300">Join now</p>
            <h1 class="mt-3 text-3xl font-black text-white">Create your account</h1>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-slate-200">Full name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white placeholder:text-slate-500 focus:border-cyan-500 focus:outline-none" placeholder="Your name" />
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-slate-200">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white placeholder:text-slate-500 focus:border-cyan-500 focus:outline-none" placeholder="you@example.com" />
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-slate-200">Password</label>
                <input id="password" name="password" type="password" required class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white placeholder:text-slate-500 focus:border-cyan-500 focus:outline-none" placeholder="Minimum 8 characters" />
            </div>

            <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-200">Confirm password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white placeholder:text-slate-500 focus:border-cyan-500 focus:outline-none" placeholder="Repeat your password" />
            </div>

            <button type="submit" class="w-full rounded-2xl bg-gradient-to-r from-cyan-500 via-blue-500 to-violet-500 px-4 py-3 text-sm font-bold uppercase tracking-[0.15em] text-white shadow-lg shadow-cyan-500/20 transition hover:brightness-110">
                Create account
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-400">
            Already have an account?
            <a href="{{ route('login') }}" class="font-semibold text-cyan-300 hover:text-cyan-200">Login here</a>
        </p>
    </div>
@endsection

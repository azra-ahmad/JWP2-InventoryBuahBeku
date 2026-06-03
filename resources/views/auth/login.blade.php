@extends('layouts.public', ['title' => 'Login Pengguna - MeyJuice'])

@section('content')
    <div class="grid min-h-[calc(100vh-120px)] items-center gap-8 lg:grid-cols-2">
        <section class="hidden rounded-2xl bg-gradient-to-br from-emerald-700 to-teal-600 p-10 text-white shadow-sm lg:block">
            <div class="mb-24 flex items-center gap-3">
                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-white/15 text-lg font-bold">MJ</span>
                <div>
                    <div class="text-lg font-semibold">MeyJuice</div>
                    <div class="text-xs text-emerald-100">Inventaris Buah Beku</div>
                </div>
            </div>
            <h1 class="max-w-md text-4xl font-semibold tracking-tight">Ruang kerja pengguna untuk menjaga stok tetap rapi.</h1>
            <p class="mt-4 max-w-md text-sm leading-6 text-emerald-50">Kelola kategori, produk, transaksi stok, dan laporan dari satu dashboard yang ringan.</p>
        </section>

        <section class="mx-auto w-full max-w-md">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold tracking-tight">Login Pengguna</h1>
                <p class="mt-1 text-sm text-slate-500">Masuk menggunakan akun pengguna pada database existing.</p>
            </div>

            @include('partials.flash')

            <form method="POST" action="{{ route('login.store') }}" class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                @csrf
                <label class="block">
                    <span class="mb-1 block text-sm font-semibold text-slate-700">Username</span>
                    <input name="username" value="{{ old('username') }}" autocomplete="username" autofocus class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none 
                    focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                </label>
                <label class="block">
                    <span class="mb-1 block text-sm font-semibold text-slate-700">Password</span>
                    <input type="password" name="password" autocomplete="current-password" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 
                    focus:ring-2 focus:ring-emerald-100">
                </label>
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" value="1" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    Ingat saya
                </label>
                <button class="w-full rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">Masuk</button>
            </form>
        </section>
    </div>
@endsection

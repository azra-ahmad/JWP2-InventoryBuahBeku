@extends('layouts.admin', ['title' => ($admin->exists ? 'Edit' : 'Tambah') . ' Pengguna - MeyJuice', 'pageTitle' => 'Pengguna'])

@section('content')
    @include('partials.page-header', [
        'title' => $admin->exists ? 'Edit Pengguna' : 'Tambah Pengguna',
        'subtitle' => 'Data pengguna disimpan ke tabel admin sesuai desain database existing.',
    ])

    <form method="POST" action="{{ $admin->exists ? route('admin.users.update', $admin) : route('admin.users.store') }}" class="max-w-2xl rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        @csrf
        @if ($admin->exists)
            @method('PUT')
        @endif
        <div class="grid gap-4 md:grid-cols-2">
            <label class="block">
                <span class="mb-1 block text-sm font-semibold text-slate-700">Nama</span>
                <input name="nama" value="{{ old('nama', $admin->nama) }}" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
            </label>
            <label class="block">
                <span class="mb-1 block text-sm font-semibold text-slate-700">Username</span>
                <input name="username" value="{{ old('username', $admin->username) }}" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
            </label>
            <label class="block md:col-span-2">
                <span class="mb-1 block text-sm font-semibold text-slate-700">Email</span>
                <input type="email" name="email" value="{{ old('email', $admin->email) }}" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
            </label>
            <label class="block md:col-span-2">
                <span class="mb-1 block text-sm font-semibold text-slate-700">Password {{ $admin->exists ? '(kosongkan jika tidak diganti)' : '' }}</span>
                <input type="password" name="password" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
            </label>
        </div>
        <div class="mt-5 flex gap-2">
            <button class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Simpan</button>
            <a href="{{ route('admin.users.index') }}" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Batal</a>
        </div>
    </form>
@endsection

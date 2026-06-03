@extends('layouts.admin', ['title' => 'Pengguna - MeyJuice', 'pageTitle' => 'Pengguna'])

@section('content')
    @include('partials.page-header', [
        'title' => 'Manajemen Pengguna',
        'subtitle' => 'Kelola pengguna yang dapat masuk ke area pengelolaan inventaris.',
        'actions' => '<a href="' . route('admin.users.create') . '" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">Tambah Pengguna</a>',
    ])

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <form method="GET" class="flex flex-col gap-3 border-b border-slate-200 p-4 sm:flex-row">
            <input name="q" value="{{ $search }}" placeholder="Cari nama, username, atau email" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 sm:max-w-sm">
            <button class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Cari</button>
        </form>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Username</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($admins as $admin)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-semibold">{{ $admin->nama }}</td>
                            <td class="px-4 py-3 font-mono text-xs text-slate-500">{{ $admin->username }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $admin->email }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $admin) }}" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-100">Edit</a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $admin) }}" onsubmit="return confirm('Hapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">Belum ada pengguna.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-200 p-4">{{ $admins->links() }}</div>
    </div>
@endsection

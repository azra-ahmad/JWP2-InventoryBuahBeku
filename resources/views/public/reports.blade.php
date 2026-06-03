@extends('layouts.public', ['title' => 'Laporan Inventaris - MeyJuice'])

@section('content')
    <section class="mb-6">
        <div class="rounded-2xl bg-gradient-to-br from-emerald-700 to-teal-600 px-5 py-8 text-white shadow-sm sm:px-8">
            <div class="max-w-3xl">
                <!-- <p class="text-sm font-semibold uppercase tracking-wide text-emerald-100">Laporan Publik</p> -->
                <h1 class="mt-2 text-3xl font-semibold tracking-tight sm:text-4xl">Pantau stok buah beku MeyJuice secara ringkas.</h1>
                <p class="mt-3 text-sm leading-6 text-emerald-50">Halaman ini hanya untuk melihat laporan inventaris, stok masuk, dan stok keluar. Akses pengelolaan tersedia khusus admin melalui tombol login.</p>
            </div>
        </div>
    </section>

    @include('reports._content', ['action' => route('reports.public')])
@endsection

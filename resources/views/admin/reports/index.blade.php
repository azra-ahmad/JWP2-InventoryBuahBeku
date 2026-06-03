@extends('layouts.admin', ['title' => 'Laporan - MeyJuice', 'pageTitle' => 'Laporan'])

@section('content')
    @include('partials.page-header', [
        'title' => 'Laporan',
        'subtitle' => 'Saring dan tinjau laporan inventaris, stok masuk, dan stok keluar.',
    ])

    @include('reports._content', ['action' => route('admin.reports.index')])
@endsection

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'MeyJuice Inventory' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
            <a href="{{ route('login') }}" class="flex items-center gap-3">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-emerald-600 text-lg font-bold text-white">MJ</span>
                <span>
                    <span class="block text-sm font-semibold">MeyJuice</span>
                    <span class="block text-xs text-slate-500">Inventaris Buah Beku</span>
                </span>
            </a>
            @unless(request()->routeIs('login'))
                @auth('admin')
                    <a href="{{ route('admin.dashboard') }}" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">Login</a>
                @endauth
            @endunless
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        @yield('content')
    </main>
</body>
</html>

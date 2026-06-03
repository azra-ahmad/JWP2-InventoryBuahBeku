<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'MeyJuice' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen lg:flex">
        <div x-cloak x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-slate-900/40 lg:hidden" @click="sidebarOpen = false"></div>

        <aside class="fixed inset-y-0 left-0 z-50 w-72 -translate-x-full border-r border-slate-200 bg-white transition lg:static lg:translate-x-0"
            :class="{ 'translate-x-0': sidebarOpen }">
            <div class="flex h-full flex-col">
                <div class="border-b border-slate-200 p-4">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                        <span class="grid h-10 w-10 place-items-center rounded-xl bg-emerald-600 text-lg font-bold text-white">MJ</span>
                        <span>
                            <span class="block text-sm font-semibold">MeyJuice</span>
                            <span class="block text-xs text-slate-500">Inventaris Buah Beku</span>
                        </span>
                    </a>
                </div>

                @php
                    $groups = [
                        'Overview' => [
                            ['Dashboard', 'admin.dashboard'],
                        ],
                        'Master Data' => [
                            ['Kategori', 'admin.categories.index'],
                            ['Produk', 'admin.products.index'],
                            ['Pengguna', 'admin.users.index'],
                        ],
                        'Inventaris' => [
                            ['Stok Masuk', 'admin.stock-in.index'],
                            ['Stok Keluar', 'admin.stock-out.index'],
                        ],
                        'Insights' => [
                            ['Laporan', 'admin.reports.index'],
                        ],
                    ];
                @endphp

                <nav class="flex-1 space-y-5 overflow-y-auto p-4">
                    @foreach ($groups as $label => $items)
                        <div>
                            <div class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400">{{ $label }}</div>
                            <div class="space-y-1">
                                @foreach ($items as [$text, $route])
                                    @php
                                        $routeParts = explode('.', $route);
                                        $sectionRoute = \Illuminate\Support\Str::beforeLast($route, '.') . '.*';
                                        $isActive = request()->routeIs($route) || (count($routeParts) > 2 && request()->routeIs($sectionRoute));
                                    @endphp
                                    <a href="{{ route($route) }}" class="block rounded-lg px-3 py-2 text-sm font-medium transition {{ $isActive ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                                        {{ $text }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </nav>

                <div class="border-t border-slate-200 p-4">
                    <div class="mb-3 rounded-xl bg-slate-50 p-3">
                        <div class="text-sm font-semibold">{{ auth('admin')->user()->nama }}</div>
                        <div class="truncate text-xs text-slate-500">{{ auth('admin')->user()->email }}</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full rounded-lg border border-slate-200 px-3 py-2 text-left text-sm font-semibold text-slate-600 transition hover:border-red-200 hover:bg-red-50 hover:text-red-700">Logout</button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="min-w-0 flex-1">
            <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/90 backdrop-blur">
                <div class="flex items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                    <button class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold lg:hidden" @click="sidebarOpen = true">Menu</button>
                    <div>
                        <div class="text-sm font-semibold">{{ $pageTitle ?? 'MeyJuice' }}</div>
                        <div class="text-xs text-slate-500">{{ now()->format('d M Y') }}</div>
                    </div>
                    <div class="h-9"></div>
                </div>
            </header>

            <main class="px-4 py-6 sm:px-6 lg:px-8">
                @include('partials.flash')
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>

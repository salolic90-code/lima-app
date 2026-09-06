<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Lima Store' }} | Lima Store</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#f5f7f6] font-sans text-[#17211d] antialiased">
        <div class="min-h-screen lg:flex">
            <aside class="flex w-full shrink-0 flex-col border-b border-[#dce5df] bg-[#10251e] text-white lg:min-h-screen lg:w-72 lg:border-b-0 lg:border-r lg:border-[#1d3b30]">
                <div class="flex items-center justify-between px-6 py-6 lg:block">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#c9f26d] font-display text-xl font-bold text-[#10251e]">L</span>
                        <span>
                            <span class="block font-display text-lg font-bold tracking-tight">Lima Store</span>
                            <span class="block text-xs text-[#9bb4a7]">Panel de gestion</span>
                        </span>
                    </a>
                    <button type="button" class="rounded-lg border border-[#315545] p-2 text-[#c9f26d] lg:hidden" aria-label="Abrir menu" onclick="document.querySelector('[data-mobile-nav]').classList.toggle('hidden')">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                </div>
                <nav data-mobile-nav class="hidden flex-1 px-4 pb-5 lg:block lg:px-5" aria-label="Navegacion principal">
                    <p class="mb-3 px-3 text-[11px] font-semibold uppercase tracking-[0.18em] text-[#719184]">Espacio de trabajo</p>
                    {{--
                        @foreach ([['dashboard', 'Resumen', 'M4 6h16M4 12h16M4 18h16'], ['clientes', 'Clientes', 'M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75'], ['productos', 'Productos', 'M20 7 12 3 4 7m16 0-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'], ['proformas', 'Proformas', 'M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM14 2v6h6M8 13h8M8 17h5'], ['configuracion', 'Configuracion', 'M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-1.42 1.42-.06-.06a1.7 1.7 0 0 0-1.88-.34 1.7 1.7 0 0 0-1.03 1.56V20h-2v-.48a1.7 1.7 0 0 0-1.03-1.56 1.7 1.7 0 0 0-1.88.34l-.06.06-1.42-1.42.06-.06A1.7 1.7 0 0 0 9.4 15a1.7 1.7 0 0 0-1.56-1.03H7v-2h.84A1.7 1.7 0 0 0 9.4 11a1.7 1.7 0 0 0-.34-1.88L9 9.06l1.42-1.42.06.06A1.7 1.7 0 0 0 12.36 8.7 1.7 1.7 0 0 0 13.39 7.14V7h2v.14A1.7 1.7 0 0 0 16.42 8.7a1.7 1.7 0 0 0 1.88-.34l.06-.06 1.42 1.42-.06.06A1.7 1.7 0 0 0 19.4 11a1.7 1.7 0 0 0 1.56 1.03H21v2h-.04A1.7 1.7 0 0 0 19.4 15z'] as $item)
                        --}}
                        <div class="grid gap-1">
                            @php
                                $navigationItems = [
                                    ['dashboard', 'Resumen', 'M4 6h16M4 12h16M4 18h16'],
                                    ['users', 'Usuarios', 'M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75'],
                                    ['clientes', 'Clientes', 'M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75'],
                                    ['productos', 'Productos', 'M20 7 12 3 4 7m16 0-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                                    ['proformas', 'Proformas', 'M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM14 2v6h6M8 13h8M8 17h5'],
                                    ['configuracion', 'Configuracion', 'M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-1.42 1.42-.06-.06a1.7 1.7 0 0 0-1.88-.34 1.7 1.7 0 0 0-1.03 1.56V20h-2v-.48a1.7 1.7 0 0 0-1.03-1.56 1.7 1.7 0 0 0-1.88.34l-.06.06-1.42-1.42.06-.06A1.7 1.7 0 0 0 9.4 15a1.7 1.7 0 0 0-1.56-1.03H7v-2h.84A1.7 1.7 0 0 0 9.4 11a1.7 1.7 0 0 0-.34-1.88L9 9.06l1.42-1.42.06.06A1.7 1.7 0 0 0 12.36 8.7 1.7 1.7 0 0 0 13.39 7.14V7h2v.14A1.7 1.7 0 0 0 16.42 8.7a1.7 1.7 0 0 0 1.88-.34l.06-.06 1.42 1.42-.06.06A1.7 1.7 0 0 0 19.4 11a1.7 1.7 0 0 0 1.56 1.03H21v2h-.04A1.7 1.7 0 0 0 19.4 15z'],
                                ];
                            @endphp
                            @foreach ($navigationItems as $item)
                            <a href="{{ route($item[0]) }}" class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition {{ request()->routeIs($item[0]) ? 'bg-[#c9f26d] text-[#10251e]' : 'text-[#b1c7bc] hover:bg-[#1c3a2d] hover:text-white' }}">
                                <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $item[2] }}" /></svg>
                                {{ $item[1] }}
                            </a>
                        @endforeach
                    </div>
                </nav>
                <div class="hidden border-t border-[#29483a] p-5 lg:block">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#315545] text-sm font-semibold text-[#c9f26d]">AS</span>
                        <div class="min-w-0"><p class="truncate text-sm font-semibold">Administrador</p><p class="truncate text-xs text-[#86a496]">admin@limastore.com</p></div>
                    </div>
                </div>
            </aside>
            <div class="min-w-0 flex-1">
                <header class="flex h-20 items-center justify-between border-b border-[#dce5df] bg-[#f8faf9] px-5 sm:px-8">
                    <div><p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#789086]">{{ $eyebrow ?? 'Panel principal' }}</p><h1 class="font-display text-xl font-bold tracking-tight text-[#17211d]">{{ $heading ?? 'Resumen' }}</h1></div>
                    <div class="flex items-center gap-3"><span class="hidden text-right sm:block"><span class="block text-sm font-semibold">{{ auth()->user()->name }}</span><span class="block text-xs text-[#789086]">Cuenta activa</span></span><span class="flex h-10 w-10 items-center justify-center rounded-full bg-[#dceab9] text-sm font-bold uppercase text-[#3b5522]">{{ substr(auth()->user()->name, 0, 2) }}</span><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="rounded-lg border border-[#dce5df] px-3 py-2 text-xs font-semibold text-[#52685d] hover:border-[#9bb5a3] hover:bg-white">Salir</button></form></div>
                </header>
                <main class="mx-auto w-full max-w-[1400px] p-5 sm:p-8">@yield('content')</main>
            </div>
        </div>
    </body>
</html>

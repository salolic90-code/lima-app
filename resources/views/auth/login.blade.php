<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Iniciar sesion | Lima Store</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#10251e] font-sans text-[#17211d] antialiased">
        <main class="grid min-h-screen lg:grid-cols-[0.85fr_1.15fr]">
            <section class="relative hidden overflow-hidden bg-[#17382b] p-10 text-white lg:flex lg:flex-col lg:justify-between">
                <div class="absolute -right-24 -top-24 h-80 w-80 rounded-full border-[48px] border-[#2d5943]"></div>
                <a href="{{ route('login') }}" class="relative flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#c9f26d] font-display text-xl font-bold text-[#10251e]">L</span>
                    <span class="font-display text-lg font-bold">Lima Store</span>
                </a>
                <div class="relative max-w-md">
                    <p class="mb-4 text-sm font-semibold uppercase tracking-[0.18em] text-[#c9f26d]">Panel de gestion</p>
                    <h1 class="font-display text-5xl font-bold leading-tight">Tu negocio, claro y bajo control.</h1>
                    <p class="mt-6 max-w-sm text-base leading-7 text-[#b1c7bc]">Gestiona clientes, productos y proformas desde un espacio diseñado para avanzar.</p>
                </div>
                <p class="relative text-xs text-[#789f8d]">Lima Store · Gestion comercial</p>
            </section>
            <section class="flex items-center justify-center bg-[#f5f7f6] px-5 py-10 sm:px-8">
                <div class="w-full max-w-md">
                    <div class="mb-8 lg:hidden"><a href="{{ route('login') }}" class="flex items-center gap-3"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#c9f26d] font-display text-xl font-bold text-[#10251e]">L</span><span class="font-display text-lg font-bold">Lima Store</span></a></div>
                    <div class="mb-8"><p class="mb-2 text-sm font-medium text-[#668277]">Bienvenido de vuelta</p><h2 class="font-display text-3xl font-bold tracking-tight">Inicia sesion</h2><p class="mt-2 text-sm text-[#6d8077]">Ingresa tus datos para continuar al panel.</p></div>
                    @if ($errors->any())
                        <div class="mb-5 rounded-xl border border-[#f0c9b9] bg-[#fff1eb] px-4 py-3 text-sm text-[#a34f30]">{{ $errors->first() }}</div>
                    @endif
                    <form method="POST" action="{{ route('login.store') }}" class="grid gap-5">
                        @csrf
                        <label class="grid gap-2 text-sm font-semibold" for="email">Correo electronico<input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="rounded-xl border border-[#dce5df] bg-white px-4 py-3 font-normal outline-none transition focus:border-[#8cad68] focus:ring-2 focus:ring-[#dff0b4]"></label>
                        <label class="grid gap-2 text-sm font-semibold" for="password">Contraseña<input id="password" name="password" type="password" required autocomplete="current-password" class="rounded-xl border border-[#dce5df] bg-white px-4 py-3 font-normal outline-none transition focus:border-[#8cad68] focus:ring-2 focus:ring-[#dff0b4]"></label>
                        <label class="flex items-center gap-2 text-sm text-[#6d8077]"><input name="remember" type="checkbox" value="1" class="h-4 w-4 rounded border-[#b8c9bf] text-[#52752b] focus:ring-[#c9f26d]">Recordarme</label>
                        <button type="submit" class="mt-2 rounded-xl bg-[#10251e] px-4 py-3.5 text-sm font-semibold text-white transition hover:bg-[#1b3b2e]">Entrar al panel</button>
                    </form>
                </div>
            </section>
        </main>
    </body>
</html>

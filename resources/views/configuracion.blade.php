@extends('layouts.dashboard')

@section('content')
    <div class="mb-8"><p class="mb-2 text-sm font-medium text-[#668277]">Preferencias</p><h2 class="font-display text-3xl font-bold tracking-tight">Configuracion</h2><p class="mt-2 text-sm text-[#6d8077]">Datos de la empresa que apareceran en tus proformas.</p></div>
    @if (session('success'))<p class="mb-5 rounded-xl bg-[#edf7e8] px-4 py-3 text-sm font-semibold text-[#4b7a35]">{{ session('success') }}</p>@endif
    @if ($errors->any())<div class="mb-5 rounded-xl bg-[#fff1eb] px-4 py-3 text-sm text-[#a34f30]">{{ $errors->first() }}</div>@endif
    <form method="POST" action="{{ route('configuracion.store') }}" enctype="multipart/form-data" class="rounded-2xl border border-[#dce5df] bg-white p-6 shadow-sm sm:p-8">@csrf
        <div class="grid gap-5 sm:grid-cols-2">
            <label class="grid gap-2 text-sm font-semibold">Nombre comercial<input name="settings[business_name]" required value="{{ $settings->firstWhere('key', 'business_name')?->value ?? 'Lima Store' }}" class="rounded-xl border border-[#dce5df] px-3 py-2.5 font-normal"></label>
            <label class="grid gap-2 text-sm font-semibold">RUC<input name="settings[tax_id]" value="{{ $settings->firstWhere('key', 'tax_id')?->value ?? '' }}" class="rounded-xl border border-[#dce5df] px-3 py-2.5 font-normal"></label>
            <label class="grid gap-2 text-sm font-semibold sm:col-span-2">Direccion<input name="settings[address]" value="{{ $settings->firstWhere('key', 'address')?->value ?? '' }}" class="rounded-xl border border-[#dce5df] px-3 py-2.5 font-normal"></label>
            <label class="grid gap-2 text-sm font-semibold">Correo<input name="settings[email]" type="email" value="{{ $settings->firstWhere('key', 'email')?->value ?? '' }}" class="rounded-xl border border-[#dce5df] px-3 py-2.5 font-normal"></label>
            <label class="grid gap-2 text-sm font-semibold">Telefono<input name="settings[phone]" value="{{ $settings->firstWhere('key', 'phone')?->value ?? '' }}" class="rounded-xl border border-[#dce5df] px-3 py-2.5 font-normal"></label>
            <label class="grid gap-2 text-sm font-semibold">IVA (%)<input name="settings[iva_rate]" type="number" step="0.01" min="0" max="100" value="{{ $settings->firstWhere('key', 'iva_rate')?->value ?? '15' }}" class="rounded-xl border border-[#dce5df] px-3 py-2.5 font-normal"></label>
            <label class="grid gap-2 text-sm font-semibold">Logo de la empresa<input name="company_logo" type="file" accept="image/png,image/jpeg,image/webp" class="rounded-xl border border-[#dce5df] bg-[#f8faf9] px-3 py-2.5 text-sm"></label>
        </div>
        @php($logo = $settings->firstWhere('key', 'logo')?->value)
        @if ($logo)<div class="mt-5 flex items-center gap-4 rounded-xl bg-[#f8faf9] p-4"><img src="{{ asset('storage/'.$logo) }}" alt="Logo actual" class="h-16 w-32 object-contain"><span class="text-sm text-[#789086]">Logo actual. Selecciona otra imagen para actualizarlo.</span></div>@endif
        <div class="mt-8 flex justify-end border-t border-[#edf1ee] pt-5"><button class="rounded-xl bg-[#10251e] px-5 py-3 text-sm font-semibold text-white">Guardar datos de empresa</button></div>
    </form>
@endsection

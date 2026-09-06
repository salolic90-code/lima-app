@extends('layouts.dashboard')

@section('content')
    <div class="mb-8 flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
        <div><p class="mb-2 text-sm font-medium text-[#668277]">Administracion</p><h2 class="font-display text-3xl font-bold tracking-tight">Usuarios</h2><p class="mt-2 text-sm text-[#6d8077]">Crea, actualiza y controla el acceso al panel.</p></div>
        <button type="button" onclick="document.getElementById('user-form').classList.toggle('hidden')" class="rounded-xl bg-[#10251e] px-4 py-3 text-sm font-semibold text-white">+ Nuevo usuario</button>
    </div>
    @if (session('success'))<p class="mb-5 rounded-xl bg-[#edf7e8] px-4 py-3 text-sm font-semibold text-[#4b7a35]">{{ session('success') }}</p>@endif
    <form id="user-form" method="POST" action="{{ route('users.store') }}" class="mb-6 hidden grid gap-4 rounded-2xl border border-[#dce5df] bg-white p-5 sm:grid-cols-2">
        @csrf
        <select name="role_id" class="rounded-xl border border-[#dce5df] px-3 py-2.5 text-sm"><option value="">Selecciona un rol</option>@foreach($roles as $role)<option value="{{ $role->id }}">{{ $role->name }}</option>@endforeach</select>
        <input name="name" required placeholder="Nombre" class="rounded-xl border border-[#dce5df] px-3 py-2.5 text-sm">
        <input name="identity_number" placeholder="Cedula" class="rounded-xl border border-[#dce5df] px-3 py-2.5 text-sm">
        <input name="email" type="email" required placeholder="Correo" class="rounded-xl border border-[#dce5df] px-3 py-2.5 text-sm">
        <input name="phone" placeholder="Telefono" class="rounded-xl border border-[#dce5df] px-3 py-2.5 text-sm">
        <input name="address" placeholder="Direccion" class="rounded-xl border border-[#dce5df] px-3 py-2.5 text-sm">
        <input name="password" type="password" required placeholder="Contraseña" class="rounded-xl border border-[#dce5df] px-3 py-2.5 text-sm">
        <button class="rounded-xl bg-[#52752b] px-4 py-2.5 text-sm font-semibold text-white sm:col-span-2">Guardar usuario</button>
    </form>
    <section class="overflow-hidden rounded-2xl border border-[#dce5df] bg-white shadow-sm">
        <div class="border-b border-[#edf1ee] p-5"><span class="text-sm text-[#789086]">{{ $users->count() }} usuarios registrados</span></div>
        <div class="overflow-x-auto"><table class="w-full min-w-[1150px] text-left text-sm"><thead class="bg-[#f8faf9] text-xs uppercase tracking-wider text-[#789086]"><tr><th class="px-5 py-4">Rol</th><th class="px-5 py-4">Nombre</th><th class="px-5 py-4">Cedula</th><th class="px-5 py-4">Correo</th><th class="px-5 py-4">Telefono</th><th class="px-5 py-4">Direccion</th><th class="px-5 py-4">Estado</th><th class="px-5 py-4">Acciones</th></tr></thead><tbody class="divide-y divide-[#edf1ee]">
            @forelse($users as $user)
                <tr>
                    <form method="POST" action="{{ route('users.update', $user) }}">@csrf @method('PATCH')
                        <td class="px-5 py-4">
                            @if($user->role?->name === 'Administrador')
                                <span class="rounded-full bg-[#eef4e6] px-2.5 py-1 text-xs font-semibold text-[#52752b]">Administrador</span>
                            @else
                                <select name="role_id" class="w-36 rounded-lg border border-[#dce5df] px-2 py-1 text-[#52752b]">@foreach($roles as $role)<option value="{{ $role->id }}" @selected($user->role_id === $role->id)>{{ $role->name }}</option>@endforeach</select>
                            @endif
                        </td>
                        <td class="px-5 py-4"><input name="name" value="{{ $user->name }}" class="w-40 rounded-lg border border-transparent px-2 py-1 font-semibold"></td>
                        <td class="px-5 py-4"><input name="identity_number" value="{{ $user->identity_number }}" class="w-32 rounded-lg border border-transparent px-2 py-1 text-[#6d8077]"></td>
                        <td class="px-5 py-4"><input name="email" type="email" value="{{ $user->email }}" class="w-44 rounded-lg border border-transparent px-2 py-1 text-[#6d8077]"></td>
                        <td class="px-5 py-4"><input name="phone" value="{{ $user->phone }}" class="w-32 rounded-lg border border-transparent px-2 py-1 text-[#6d8077]"></td>
                        <td class="px-5 py-4"><input name="address" value="{{ $user->address }}" class="w-40 rounded-lg border border-transparent px-2 py-1 text-[#6d8077]"></td>
                        <td class="px-5 py-4"><span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $user->active ? 'bg-[#edf7e8] text-[#4b7a35]' : 'bg-[#f1f1f1] text-[#777]' }}">{{ $user->active ? 'Activo' : 'Inactivo' }}</span></td>
                        <td class="px-5 py-4"><button class="mr-2 text-xs font-semibold text-[#52752b]">Guardar</button></form><form class="inline" method="POST" action="{{ route('users.toggle', $user) }}">@csrf @method('PATCH')<button class="text-xs font-semibold text-[#a06a2e]">{{ $user->active ? 'Inactivar' : 'Activar' }}</button></form></td>
                </tr>
            @empty
                <tr><td colspan="8" class="p-10 text-center text-sm text-[#789086]">No hay usuarios registrados.</td></tr>
            @endforelse
        </tbody></table></div>
    </section>
    @if (auth()->user()->role?->name === 'Administrador')
        <section class="mt-6 overflow-hidden rounded-2xl border border-[#dce5df] bg-white shadow-sm"><div class="border-b border-[#edf1ee] p-5"><h3 class="font-display text-lg font-bold">Roles del sistema</h3><p class="mt-1 text-sm text-[#789086]">Administrados por el administrador del sistema.</p></div><form method="POST" action="{{ route('roles.store') }}" class="grid gap-3 border-b border-[#edf1ee] p-5 sm:grid-cols-[1fr_auto]">@csrf<input name="name" required placeholder="Nuevo rol" class="rounded-xl border border-[#dce5df] px-3 py-2.5 text-sm"><button class="rounded-xl bg-[#52752b] px-4 py-2.5 text-sm font-semibold text-white">Crear rol</button></form><div class="divide-y divide-[#edf1ee]">@foreach($allRoles as $role)<div class="flex items-center justify-between gap-4 p-5"><form method="POST" action="{{ route('roles.update', $role) }}" class="flex flex-1 gap-3">@csrf @method('PATCH')<input name="name" value="{{ $role->name }}" class="w-full max-w-sm rounded-lg border border-transparent px-2 py-1 font-semibold"><button class="text-xs font-semibold text-[#52752b]">Guardar</button></form><form method="POST" action="{{ route('roles.toggle', $role) }}">@csrf @method('PATCH')<button class="text-xs font-semibold text-[#a06a2e]">{{ $role->active ? 'Inactivar' : 'Activar' }}</button></form></div>@endforeach</div></section>
    @endif
@endsection

<?php

use App\Models\Category;
use App\Models\Client;
use App\Models\Product;
use App\Models\Proforma;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    })->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/users', function () {
        return view('users', [
            'users' => User::with('role')->latest()->get(),
            'roles' => Role::where('active', true)->orderBy('name')->get(),
            'allRoles' => Role::orderBy('name')->get(),
        ]);
    })->name('users');
    Route::post('/users', function (Request $request) {
        $data = $request->validate(['name' => ['required', 'string', 'max:255'], 'role_id' => ['nullable', 'exists:roles,id'], 'identity_number' => ['nullable', 'string', 'max:30'], 'email' => ['required', 'email', 'unique:users,email'], 'phone' => ['nullable', 'string', 'max:30'], 'address' => ['nullable', 'string', 'max:255'], 'password' => ['required', 'string', 'min:3']]);
        User::create($data);

        return back()->with('success', 'Usuario creado correctamente.');
    })->name('users.store');
    Route::patch('/users/{user}', function (Request $request, User $user) {
        $rules = ['name' => ['required', 'string', 'max:255'], 'identity_number' => ['nullable', 'string', 'max:30'], 'email' => ['required', 'email', 'unique:users,email,'.$user->id], 'phone' => ['nullable', 'string', 'max:30'], 'address' => ['nullable', 'string', 'max:255']];

        if ($user->role?->name !== 'Administrador') {
            $rules['role_id'] = ['nullable', 'exists:roles,id'];
        }

        $data = $request->validate($rules);
        $user->update($data);

        return back()->with('success', 'Usuario actualizado.');
    })->name('users.update');
    Route::patch('/users/{user}/toggle', function (User $user) {
        $user->update(['active' => ! $user->active]);

        return back()->with('success', 'Estado del usuario actualizado.');
    })->name('users.toggle');

    Route::post('/roles', function (Request $request) {
        abort_unless(Auth::user()?->role?->name === 'Administrador', 403);
        Role::create($request->validate(['name' => ['required', 'string', 'max:100', 'unique:roles,name']]));

        return back()->with('success', 'Rol creado correctamente.');
    })->name('roles.store');
    Route::patch('/roles/{role}', function (Request $request, Role $role) {
        abort_unless(Auth::user()?->role?->name === 'Administrador', 403);
        $role->update($request->validate(['name' => ['required', 'string', 'max:100', 'unique:roles,name,'.$role->id]]));

        return back()->with('success', 'Rol actualizado.');
    })->name('roles.update');
    Route::patch('/roles/{role}/toggle', function (Role $role) {
        abort_unless(Auth::user()?->role?->name === 'Administrador', 403);
        $role->update(['active' => ! $role->active]);

        return back()->with('success', 'Estado del rol actualizado.');
    })->name('roles.toggle');

    Route::get('/clientes', fn () => view('clientes', ['clients' => Client::latest()->get()]))->name('clientes');
    Route::post('/clientes', function (Request $request) {
        Client::create($request->validate(['name' => ['required', 'string', 'max:255'], 'ruc_ci' => ['nullable', 'string', 'max:30'], 'address' => ['nullable', 'string', 'max:255'], 'email' => ['nullable', 'email'], 'phone' => ['nullable', 'string', 'max:30']]));

        return back()->with('success', 'Cliente creado correctamente.');
    })->name('clientes.store');
    Route::patch('/clientes/{client}', function (Request $request, Client $client) {
        $client->update($request->validate(['name' => ['required', 'string', 'max:255'], 'ruc_ci' => ['nullable', 'string', 'max:30'], 'address' => ['nullable', 'string', 'max:255'], 'email' => ['nullable', 'email'], 'phone' => ['nullable', 'string', 'max:30']]));

        return back()->with('success', 'Cliente actualizado.');
    })->name('clientes.update');
    Route::patch('/clientes/{client}/toggle', function (Client $client) {
        $client->update(['active' => ! $client->active]);

        return back()->with('success', 'Estado del cliente actualizado.');
    })->name('clientes.toggle');

    Route::get('/productos', fn () => view('productos', ['products' => Product::with('categoryRelation')->latest()->get(), 'categories' => Category::where('active', true)->orderBy('name')->get(), 'allCategories' => Category::orderBy('name')->get()]))->name('productos');
    Route::post('/productos', function (Request $request) {
        $data = $request->validate(['name' => ['required', 'string', 'max:255'], 'category_id' => ['nullable', 'exists:categories,id'], 'price' => ['required', 'numeric', 'min:0'], 'stock' => ['required', 'integer', 'min:0']]);
        $data['category'] = Category::find($data['category_id'] ?? null)?->name;
        Product::create($data);

        return back()->with('success', 'Producto creado correctamente.');
    })->name('productos.store');
    Route::patch('/productos/{product}', function (Request $request, Product $product) {
        $data = $request->validate(['name' => ['required', 'string', 'max:255'], 'category_id' => ['nullable', 'exists:categories,id'], 'price' => ['required', 'numeric', 'min:0'], 'stock' => ['required', 'integer', 'min:0']]);
        $data['category'] = Category::find($data['category_id'] ?? null)?->name;
        $product->update($data);

        return back()->with('success', 'Producto actualizado.');
    })->name('productos.update');
    Route::patch('/productos/{product}/toggle', function (Product $product) {
        $product->update(['active' => ! $product->active]);

        return back()->with('success', 'Estado del producto actualizado.');
    })->name('productos.toggle');

    Route::post('/categories', function (Request $request) {
        abort_unless(Auth::user()?->role?->name === 'Administrador', 403);
        Category::create($request->validate(['name' => ['required', 'string', 'max:100', 'unique:categories,name']]));

        return back()->with('success', 'Categoria creada correctamente.');
    })->name('categories.store');
    Route::patch('/categories/{category}', function (Request $request, Category $category) {
        abort_unless(Auth::user()?->role?->name === 'Administrador', 403);
        $data = $request->validate(['name' => ['required', 'string', 'max:100', 'unique:categories,name,'.$category->id]]);
        $category->update($data);
        Product::where('category_id', $category->id)->update(['category' => $category->name]);

        return back()->with('success', 'Categoria actualizada.');
    })->name('categories.update');
    Route::patch('/categories/{category}/toggle', function (Category $category) {
        abort_unless(Auth::user()?->role?->name === 'Administrador', 403);
        $category->update(['active' => ! $category->active]);

        return back()->with('success', 'Estado de la categoria actualizado.');
    })->name('categories.toggle');

    Route::get('/proformas', fn () => view('proformas', ['proformas' => Proforma::with('client')->latest()->get(), 'clients' => Client::where('active', true)->orderBy('name')->get(), 'products' => Product::where('active', true)->orderBy('name')->get(), 'companyIva' => Setting::where('key', 'iva_rate')->value('value') ?? 15]))->name('proformas');
    Route::post('/proformas', function (Request $request) {
        $data = $request->validate(['client_id' => ['nullable', 'exists:clients,id'], 'customer_ruc_ci' => ['nullable', 'string', 'max:30'], 'customer_address' => ['nullable', 'string', 'max:255'], 'customer_phone' => ['nullable', 'string', 'max:30'], 'customer_code' => ['nullable', 'string', 'max:80'], 'quote_date' => ['required', 'date'], 'validity_days' => ['required', 'integer', 'min:1'], 'purchase_object' => ['nullable', 'string'], 'product_code' => ['nullable', 'string', 'max:50'], 'product_description' => ['required', 'string'], 'unit' => ['required', 'string', 'max:30'], 'quantity' => ['required', 'integer', 'min:1'], 'unit_price' => ['required', 'numeric', 'min:0'], 'tax_rate' => ['required', 'numeric', 'min:0'], 'payment_method' => ['required', 'string', 'max:30'], 'status' => ['required', 'in:pending,approved,rejected']]);
        $data['total'] = round($data['quantity'] * $data['unit_price'] * (1 + ($data['tax_rate'] / 100)), 2);
        $proforma = DB::transaction(function () use ($data) {
            $proforma = Proforma::create($data + ['number' => 'TMP-'.Str::uuid()]);
            $number = 6020 + $proforma->id;

            while (Proforma::where('number', (string) $number)->where('id', '!=', $proforma->id)->exists()) {
                $number++;
            }

            $proforma->update(['number' => (string) $number]);

            return $proforma->refresh();
        });

        return redirect()->route('proformas')->with('success', 'Proforma creada correctamente.')->with('created_proforma', $proforma->id);
    })->name('proformas.store');
    Route::patch('/proformas/{proforma}', function (Request $request, Proforma $proforma) {
        $proforma->update($request->validate(['client_id' => ['nullable', 'exists:clients,id'], 'total' => ['required', 'numeric', 'min:0'], 'status' => ['required', 'in:pending,approved,rejected']]));

        return back()->with('success', 'Proforma actualizada.');
    })->name('proformas.update');
    Route::patch('/proformas/{proforma}/toggle', function (Proforma $proforma) {
        $proforma->update(['active' => ! $proforma->active]);

        return back()->with('success', 'Estado de la proforma actualizado.');
    })->name('proformas.toggle');
    Route::get('/proformas/{proforma}/print', function (Proforma $proforma) {
        return view('proformas.print', [
            'proforma' => $proforma->load('client'),
            'companySettings' => Setting::whereIn('key', ['business_name', 'tax_id', 'address', 'email', 'phone', 'iva_rate', 'logo'])->pluck('value', 'key'),
        ]);
    })->name('proformas.print');

    Route::get('/configuracion', fn () => view('configuracion', ['settings' => Setting::orderBy('key')->get()]))->name('configuracion');
    Route::post('/configuracion', function (Request $request) {
        $request->validate([
            'settings.business_name' => ['required', 'string', 'max:255'],
            'settings.tax_id' => ['nullable', 'string', 'max:30'],
            'settings.address' => ['nullable', 'string', 'max:255'],
            'settings.email' => ['nullable', 'email'],
            'settings.phone' => ['nullable', 'string', 'max:30'],
            'settings.iva_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'company_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        foreach ($request->input('settings', []) as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        if ($request->hasFile('company_logo')) {
            $oldLogo = Setting::where('key', 'logo')->value('value');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }

            $logoPath = $request->file('company_logo')->store('company', 'public');
            Setting::updateOrCreate(['key' => 'logo'], ['value' => $logoPath]);
        }

        return back()->with('success', 'Configuracion guardada.');
    })->name('configuracion.store');
    Route::patch('/configuracion/{setting}/toggle', function (Setting $setting) {
        $setting->update(['active' => ! $setting->active]);

        return back()->with('success', 'Estado de la configuracion actualizado.');
    })->name('configuracion.toggle');

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');
});

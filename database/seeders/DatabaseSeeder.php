<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'Administrador']);
        Role::firstOrCreate(['name' => 'Vendedor']);
        Role::firstOrCreate(['name' => 'Consulta']);
        Category::firstOrCreate(['name' => 'Tecnologia']);
        Category::firstOrCreate(['name' => 'Mobiliario']);

        User::updateOrCreate(['email' => 'admin@limastore.com'], [
            'name' => 'Administrador',
            'password' => Hash::make('123'),
            'email_verified_at' => now(),
            'role_id' => $adminRole->id,
        ]);
    }
}

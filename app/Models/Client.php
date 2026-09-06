<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'ruc_ci', 'address', 'email', 'phone', 'active'];

    protected function casts(): array
    {
        return ['active' => 'boolean'];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proforma extends Model
{
    protected $fillable = ['number', 'client_id', 'total', 'status', 'active', 'customer_ruc_ci', 'customer_address', 'customer_phone', 'customer_code', 'quote_date', 'validity_days', 'purchase_object', 'product_code', 'product_description', 'unit', 'quantity', 'unit_price', 'tax_rate', 'payment_method'];

    protected function casts(): array
    {
        return ['total' => 'decimal:2', 'unit_price' => 'decimal:2', 'tax_rate' => 'decimal:2', 'quote_date' => 'date', 'active' => 'boolean'];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('proformas', function (Blueprint $table) {
            $table->string('customer_ruc_ci')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_code')->nullable();
            $table->date('quote_date')->nullable();
            $table->unsignedInteger('validity_days')->default(30);
            $table->text('purchase_object')->nullable();
            $table->string('product_code')->nullable();
            $table->text('product_description')->nullable();
            $table->string('unit')->default('UNIDAD');
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(15);
            $table->string('payment_method')->default('EFECTIVO');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proformas', function (Blueprint $table) {
            $table->dropColumn(['customer_ruc_ci', 'customer_address', 'customer_phone', 'customer_code', 'quote_date', 'validity_days', 'purchase_object', 'product_code', 'product_description', 'unit', 'quantity', 'unit_price', 'tax_rate', 'payment_method']);
        });
    }
};

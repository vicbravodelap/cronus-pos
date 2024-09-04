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
        Schema::create('sale_order_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\SaleOrder::class);
            $table->decimal('amount', 10, 2);
            $table->foreignIdFor(\App\Models\PaymentMethod::class);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_order_payments');
    }
};

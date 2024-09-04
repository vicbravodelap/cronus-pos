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
        Schema::create('sale_orders', function (Blueprint $table) {
            $table->id();

            $table->enum(
                'status',
                [
                    'pending',
                    'processing',
                    'completed',
                    'cancelled'
                ]
            )->default('pending');

            $table->decimal('total', 10, 2);
            $table->foreignIdFor(\App\Models\User::class)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_orders');
    }
};

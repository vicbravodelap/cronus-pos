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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\Product::class);
            $table->integer('quantity');
            $table->dateTime('last_received_at')->nullable();
            $table->dateTime('last_sold_at')->nullable();
            $table->integer('reorder_level')->default(0);
            $table->integer('max_level')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};

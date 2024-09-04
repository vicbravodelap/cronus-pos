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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignIdFor(\App\Models\Category::class);
            $table->decimal('price', 10, 2);
            $table->decimal('discount', 10, 2)->nullable()->default(0);
            $table->string('sku')->unique()->nullable();
            $table->enum('status', ['active', 'inactive', 'discontinued'])->default('active');
            $table->text('image_path')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

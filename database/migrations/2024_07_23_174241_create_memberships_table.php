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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\User::class);
            $table->dateTime('start_at');
            $table->dateTime('end_at');

            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignIdFor(\App\Models\Promotion::class)->nullable();

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};

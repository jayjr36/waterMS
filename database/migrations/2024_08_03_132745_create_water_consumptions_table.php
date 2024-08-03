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
        Schema::create('water_consumption', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Peter Paul');
            $table->string('address')->default('Ubungo');
            $table->integer('units_consumed');
            $table->boolean('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('water_consumptions');
    }
};

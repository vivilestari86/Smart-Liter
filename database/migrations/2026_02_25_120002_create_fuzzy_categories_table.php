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
        Schema::create('fuzzy_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fuzzy_parameter_id')
                ->constrained('fuzzy_parameters')
                ->cascadeOnDelete();
            $table->string('name');

            $table->decimal('titik_a_x', 10, 2);
            $table->decimal('titik_a_y', 10, 2);
            $table->decimal('titik_b_x', 10, 2);
            $table->decimal('titik_b_y', 10, 2);
            $table->decimal('titik_c_x', 10, 2);
            $table->decimal('titik_c_y', 10, 2);
            $table->decimal('titik_d_x', 10, 2);
            $table->decimal('titik_d_y', 10, 2);
            $table->timestamps();

            $table->unique(['fuzzy_parameter_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuzzy_categories');
    }
};

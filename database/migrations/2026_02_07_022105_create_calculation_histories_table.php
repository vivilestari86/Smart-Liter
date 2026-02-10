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
    Schema::create('calculation_histories', function (Blueprint $table) {
        $table->id();
        $table->string('ip')->nullable();
        $table->decimal('suhu', 5, 2)->nullable();
        $table->decimal('kelembapan_udara', 5, 2)->nullable();
        $table->decimal('kelembapan_tanah', 5, 2)->nullable();
        $table->integer('usia_tanaman')->nullable();

        $table->decimal('output_liter', 10, 2)->nullable();
        $table->string('kategori')->nullable(); // mati / sedikit / banyak (atau lainnya)
        $table->text('deskripsi')->nullable();  // detail perhitungan

        $table->timestamps(); // created_at = tanggal
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculation_histories');
    }
};

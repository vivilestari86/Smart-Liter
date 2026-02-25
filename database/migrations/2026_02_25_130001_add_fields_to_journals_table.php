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
        Schema::table('journals', function (Blueprint $table) {
            $table->string('title')->nullable()->after('id');
            $table->string('author')->nullable()->after('title');
            $table->text('summary')->nullable()->after('author');
            $table->string('status')->default('Draft')->after('summary');
            $table->timestamp('published_at')->nullable()->after('status');
            $table->string('pdf_path')->nullable()->after('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'author',
                'summary',
                'status',
                'published_at',
                'pdf_path',
            ]);
        });
    }
};

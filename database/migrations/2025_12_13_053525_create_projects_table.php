<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable(); // Gambar utama
            $table->longText('content')->nullable(); // Deskripsi lengkap (Rich Text)
            $table->string('demo_url')->nullable();
            $table->string('github_url')->nullable();
            $table->integer('sort_order')->default(0); // Untuk atur urutan
            $table->boolean('is_active')->default(true); // Draft/Publish
            $table->date('published_at')->nullable();
            $table->timestamps();
        });

        // Kita buat tabel pivot langsung disini agar ringkas
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

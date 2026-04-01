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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('role'); // Jabatan
            $table->date('start_date');
            $table->date('end_date')->nullable(); // Nullable jika masih bekerja
            $table->boolean('is_current')->default(false); // Penanda "Present"
            $table->text('description')->nullable();
            $table->string('type')->default('work'); // work atau education
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};

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
        Schema::create('keunggulan_kami', function (Blueprint $table) {
            $table->id();
            $table->string('gambar_ikon')->nullable(); // Path ke file gambar ikon
            $table->string('judul');
            $table->text('deskripsi');
            $table->boolean('is_active')->default(1);
            $table->integer('urutan')->default(0); // Untuk sorting
            $table->integer('created_by')->default(0);
            $table->integer('update_by')->default(0);
            $table->integer('delete_by')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keunggulan_kami');
    }
};
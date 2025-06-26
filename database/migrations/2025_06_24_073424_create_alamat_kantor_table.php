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
        Schema::create('alamat_kantor', function (Blueprint $table) {
            $table->id();
            $table->text('alamat');
            $table->string('no_telepon', 20);
            $table->string('email');
            $table->text('link_maps')->nullable(); // Tambahan field untuk Google Maps
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->integer('deleted_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamat_kantor');
    }
};
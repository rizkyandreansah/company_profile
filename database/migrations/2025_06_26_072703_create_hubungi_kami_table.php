<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hubungi_kami', function (Blueprint $table) {
            $table->id();
            $table->text('full_name'); // encrypted
            $table->text('email'); // encrypted
            $table->text('phone'); // encrypted
            $table->text('message');
            $table->boolean('is_read')->default(0); // 0 = belum dibaca, 1 = sudah dibaca
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
            $table->index(['is_read', 'deleted_at']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hubungi_kami');
    }
};
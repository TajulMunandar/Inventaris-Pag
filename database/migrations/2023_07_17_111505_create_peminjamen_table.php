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
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_pinjam');
            $table->date('tgl_balik')->nullable();
            $table->string('deskripsi');
            $table->boolean('status');
            $table->boolean('isApprove');
            $table->integer('qty');
            $table->foreignId('userId')->constrained('users')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('barangId')->constrained('barangs')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};

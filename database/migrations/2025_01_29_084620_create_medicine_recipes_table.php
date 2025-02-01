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
        Schema::create('medicine_recipes', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_resep')->nullable();
            $table->foreign('id_resep')->references('id_resep')->on('medical_prescriptions');
            $table->string('id_obat');
            $table->string('nama_obat');
            $table->integer('jumlah');
            $table->text('aturan_pakai');
            $table->integer('harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicine_recipes');
    }
};

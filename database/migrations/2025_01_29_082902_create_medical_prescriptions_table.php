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
        Schema::create('medical_prescriptions', function (Blueprint $table) {
            $table->id('id_resep');
            $table->char('id_dokter', 5)->nullable();
            $table->foreign('id_dokter')->references('id_dokter')->on('doctors')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('id_rekmed')->nullable();
            $table->foreign('id_rekmed')->references('id_rekmed')->on('medical_records')->onDelete('cascade');
            $table->enum('status', ['menunggu', 'selesai'])->default('menunggu');
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
        Schema::dropIfExists('medical_prescriptions');
    }
};

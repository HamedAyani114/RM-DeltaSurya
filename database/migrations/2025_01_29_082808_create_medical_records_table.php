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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id('id_rekmed');
            $table->char('id_dokter', 5)->nullable();
            $table->foreign('id_dokter')->references('id_dokter')->on('doctors');
            $table->char('id_pasien', 5)->nullable();
            $table->foreign('id_pasien')->references('id_pasien')->on('patients');
            $table->char('id_poli', 5)->nullable();
            $table->foreign('id_poli')->references('id_poli')->on('polies');

            $table->integer('berat_badan');
            $table->integer('tinggi_badan');
            $table->integer('sistole');
            $table->integer('diastole');
            $table->integer('gula_darah');
            $table->integer('heart_rate');
            $table->integer('respiration_rate');
            $table->integer('suhu_tubuh');
            $table->text('keluhan', 255);
            $table->text('diagnosis', 255);
            $table->text('alergi', 255)->nullable();
            $table->text('terapi', 255);
            $table->string('berkas_pemeriksaan')->nullable();

            $table->timestamp('tgl_periksa');
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
        Schema::dropIfExists('medical_records');
    }
};

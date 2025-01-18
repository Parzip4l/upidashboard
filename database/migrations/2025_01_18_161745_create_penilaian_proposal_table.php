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
        Schema::create('penilaian_proposal', function (Blueprint $table) {
            $table->id();
            $table->string('id_proposal', 50);
            $table->string('reviewer', 100);
            $table->tinyInteger('tujuan_sasaran')->unsigned()->checkBetween(1, 4);
            $table->tinyInteger('metodologi')->unsigned()->checkBetween(1, 4);
            $table->tinyInteger('jadwal_tahapan')->unsigned()->checkBetween(1, 4);
            $table->tinyInteger('inovasi')->unsigned()->checkBetween(1, 4);
            $table->tinyInteger('keberlanjutan_program')->unsigned()->checkBetween(1, 4);
            $table->tinyInteger('dampak_sosial_ekonomi')->unsigned()->checkBetween(1, 4);
            $table->tinyInteger('capaian_iku')->unsigned()->checkBetween(1, 4);
            $table->tinyInteger('implementasi')->unsigned()->checkBetween(1, 4);
            $table->tinyInteger('sdm')->unsigned()->checkBetween(1, 4);
            $table->tinyInteger('anggaran')->unsigned()->checkBetween(1, 4);
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
        Schema::dropIfExists('penilaian_proposal');
    }
};

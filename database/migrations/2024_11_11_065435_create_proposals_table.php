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
        Schema::create('proposals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fakultas_kamda');
            $table->string('prodi');
            $table->string('ketua_inovator');
            $table->string('nama_industri');
            $table->enum('tkt', [6, 7, 8, 9]);
            $table->string('bukti_tkt');
            $table->string('judul_proposal');
            $table->string('skema');
            $table->string('tema');
            $table->decimal('rencana_anggaran_biaya', 15, 2);
            $table->integer('durasi_pelaksanaan');
            $table->decimal('dana_hilirisasi_inovasi', 15, 2);
            $table->decimal('mitra_tunai', 15, 2);
            $table->decimal('mitra_natura', 15, 2);
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
        Schema::dropIfExists('proposals');
    }
};

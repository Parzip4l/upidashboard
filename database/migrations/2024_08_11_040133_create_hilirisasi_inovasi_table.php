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
        Schema::create('hilirisasi_inovasi', function (Blueprint $table) {
            $table->id();
            $table->string('nidn_nidk_nup');
            $table->string('nama_perguruan_tinggi');
            $table->string('program_studi');
            $table->string('nomor_ktp');
            $table->date('tanggal_lahir');
            $table->string('nomor_telepon');
            $table->text('deskripsi_profil');
            $table->string('kata_kunci');

            // Profile Produk Inovasi
            $table->string('judul_inovasi');
            $table->string('inventor_contact_person');
            $table->text('deskripsi_keunggulan_inovasi');
            $table->string('foto_produk_inovasi')->nullable(); 
            $table->string('dokumen_produk_inovasi')->nullable(); 
            $table->string('status')->default('review'); 
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
        Schema::dropIfExists('hilirisasi_inovasi');
    }
};

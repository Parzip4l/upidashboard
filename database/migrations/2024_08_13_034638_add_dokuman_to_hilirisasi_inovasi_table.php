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
        Schema::table('hilirisasi_inovasi', function (Blueprint $table) {
            $table->string('poster_inovasi')->nullable();
            $table->string('powerpoint')->nullable(); 
            $table->string('video_inovasi')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hilirisasi_inovasi', function (Blueprint $table) {
            //
        });
    }
};

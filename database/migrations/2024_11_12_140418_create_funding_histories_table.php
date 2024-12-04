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
        Schema::create('funding_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_composition_id');
            $table->string('proposal_title');
            $table->integer('year');
            $table->string('name');
            $table->enum('status', ['Ketua', 'Anggota']);
            $table->timestamps();
    
            $table->foreign('team_composition_id')->references('id')->on('team_compositions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funding_histories');
    }
};

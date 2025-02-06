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
        Schema::create('reviewers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_proposal')->unique();
            $table->unsignedBigInteger('reviewer1');
            $table->unsignedBigInteger('reviewer2');
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_proposal')->references('id')->on('proposals')->onDelete('cascade');
            $table->foreign('reviewer1')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewer2')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviewers');
    }
};

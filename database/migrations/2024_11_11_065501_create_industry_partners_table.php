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
        Schema::create('industry_partners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('proposal_id')->constrained('proposals')->onDelete('cascade');
            $table->string('name');
            $table->string('business_focus');
            $table->string('business_scale');
            $table->string('address');
            $table->string('email')->unique();
            $table->string('phone');
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
        Schema::dropIfExists('industry_partners');
    }
};

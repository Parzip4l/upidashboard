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
        Schema::create('collaborations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('proposal_id')->constrained('proposals')->onDelete('cascade');
            $table->text('background');
            $table->text('target_users');
            $table->text('success_metrics');
            $table->text('implementation_needs');
            $table->text('cooperation_expectation');
            $table->text('industry_problems');
            $table->text('solution_description');
            $table->text('proposed_incentives');
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
        Schema::dropIfExists('collaborations');
    }
};

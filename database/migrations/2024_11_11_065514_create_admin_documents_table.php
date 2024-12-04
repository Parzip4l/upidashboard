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
        Schema::create('admin_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('proposal_id')->constrained('proposals')->onDelete('cascade');
            $table->string('proposal_file');
            $table->string('partner_commitment_letter');
            $table->string('funding_commitment_letter');
            $table->string('study_commitment_letter');
            $table->string('applicant_bio_form');
            $table->string('partner_profile_form');
            $table->string('cooperation_agreement');
            $table->string('hki_agreement');
            $table->string('budget_plan_file');
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
        Schema::dropIfExists('admin_documents');
    }
};

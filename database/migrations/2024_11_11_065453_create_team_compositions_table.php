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
        Schema::create('team_compositions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('proposal_id')->constrained('proposals')->onDelete('cascade');
            $table->enum('member_type', ['Dosen', 'Staf', 'Mahasiswa']);
            $table->string('name');
            $table->string('identifier'); // NIDN, NIP, NIM, etc.
            $table->string('faculty_kamda')->nullable();
            $table->string('program')->nullable();
            $table->string('position')->nullable();
            $table->boolean('active_status')->default(true);
            $table->text('funding_history')->nullable();
            $table->boolean('is_lead')->default(false);
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
        Schema::dropIfExists('team_compositions');
    }
};

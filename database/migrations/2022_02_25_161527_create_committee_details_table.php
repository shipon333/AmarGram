<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommitteeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('committee_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->references('id')->on('members');
            $table->foreignId('committee_id')->references('id')->on('committees');
            $table->foreignId('committee_designation_id')->references('id')->on('committee_designations');
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
        Schema::dropIfExists('committee_details');
    }
}

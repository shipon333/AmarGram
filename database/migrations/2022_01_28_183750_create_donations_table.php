<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('donor_name')->nullable();
            $table->foreignId('people_id')->nullable()->references('id')->on('peoples');
            $table->unsignedDouble('amount');
            $table->foreignId('project_id')->nullable()->constrained();
            $table->foreignId('organization_id')->constrained();
            $table->foreignId('received_by')->references('id')->on('peoples');
            $table->text('note')->nullable();
            $table->date('donation_date')->useCurrent();
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
        Schema::dropIfExists('donations');
    }
}

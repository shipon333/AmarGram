<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeoplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peoples', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->unique();
            $table->unsignedBigInteger('nid')->nullable()->unique();
            $table->string('birth_registration')->nullable()->unique();
            $table->string('passport_no')->nullable()->unique();
            $table->string('driving_license')->nullable()->unique();
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->foreignId('father_id')->nullable()->references('id')->on('peoples');
            $table->string('mother_name')->nullable();
            $table->foreignId('mother_id')->nullable()->references('id')->on('peoples');
            $table->date('dob');
            $table->date('dod')->nullable();
            $table->date('dom')->nullable();
            $table->string('mobile_numbers')->nullable();
            $table->string('email')->nullable();
            $table->string('profession')->nullable();
            $table->foreignId('para_id')->nullable();
            $table->foreignId('village_id');
            $table->string('marital_status')->nullable();
            $table->string('spouse_name')->nullable();
            $table->foreignId('spouse_id')->nullable()->references('id')->on('peoples');
            $table->text('spouse_address')->nullable();
            $table->string('blood_group')->nullable();
            $table->foreignId('dependent_on')->nullable()->references('id')->on('peoples');
            $table->boolean('old_age_allowance')->default(false);
            $table->boolean('is_freedom_fighter')->default(false);
            $table->boolean('freedom_fighter_allowance')->default(false);
            $table->boolean('is_disabled')->default(false);
            $table->boolean('disability_allowance')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peoples');
    }
}

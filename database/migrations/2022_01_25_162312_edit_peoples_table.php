<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditPeoplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peoples', function (Blueprint $table){
            $table->unsignedSmallInteger('ward_no')->nullable();
            $table->unsignedFloat('height')->nullable();
            $table->unsignedFloat('weight')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peoples', function (Blueprint $table){
            $table->dropColumn(['ward_no','height','weight']);
        });
    }
}

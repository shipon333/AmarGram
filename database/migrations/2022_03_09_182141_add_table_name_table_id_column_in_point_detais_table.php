<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableNameTableIdColumnInPointDetaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('point_details', function (Blueprint $table) {
            $table->string('table_name')->after('point');
            $table->unsignedBigInteger('table_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('point_details', function (Blueprint $table) {
            $table->dropColumn('table_name');
            $table->dropColumn('table_id');
        });
    }
}

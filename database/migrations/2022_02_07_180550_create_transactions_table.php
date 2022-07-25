<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('payer')->nullable();
            $table->string('payee')->nullable();
            $table->unsignedDouble('debit')->default(0);
            $table->unsignedDouble('credit')->default(0);
            $table->date('trx_date')->useCurrent();
            $table->string('trx_code')->nullable();
            $table->string('table_name');
            $table->unsignedBigInteger('table_id');
            $table->text('note')->nullable();
            $table->foreignId('account_id')->constrained();
            $table->double('balance')->default(0);
            $table->foreignId('organization_id')->constrained();
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('transactions');
    }
}

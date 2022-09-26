<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('school_id');
            $table->string('account_name');
            $table->string('account_title')->nullable();
            $table->string('bank_name');
            $table->string('bank_address');
            $table->string('bank_zip');
            $table->string('bank_phone');
            $table->string('account_number');
            $table->string('beneficiary_address');
            $table->string('beneficiary_zip')->nullable();
            $table->string('sort_code');
            $table->string('swift_code');
            $table->string('iban_number');
            $table->string('currency');
            $table->string('bic_number')->nullable();
            $table->string('reference')->nullable();
            $table->timestamps();

            $table->foreign('school_id')
                ->references('id')->on('schools')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_accounts');
    }
}

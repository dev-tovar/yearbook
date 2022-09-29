<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->unsignedInteger('school_id')->index('bank_accounts_school_id_foreign');
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->timestamps();
            $table->string('zelle_account')->nullable();
            $table->string('paypal_username')->nullable();
            $table->string('cashapp_username')->nullable();
            $table->string('venmo_username')->nullable();
            $table->text('donation_link')->nullable();
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

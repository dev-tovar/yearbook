<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->string('zelle_account')->nullable();
            $table->string('paypal_username')->nullable();
            $table->string('cashapp_username')->nullable();
            $table->string('venmo_username')->nullable();

            $table->string('bank_name')->nullable()->change();
            $table->string('account_number')->nullable()->change();

            $table->dropColumn('account_name');
            $table->dropColumn('account_title');
            $table->dropColumn('bank_address');
            $table->dropColumn('bank_zip');
            $table->dropColumn('bank_phone');
            $table->dropColumn('beneficiary_address');
            $table->dropColumn('beneficiary_zip');
            $table->dropColumn('sort_code');
            $table->dropColumn('swift_code');
            $table->dropColumn('iban_number');
            $table->dropColumn('currency');
            $table->dropColumn('bic_number');
            $table->dropColumn('reference');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->string('bank_name')->change();
            $table->string('account_number')->change();

            $table->string('account_name');
            $table->string('account_title')->nullable();
            $table->string('bank_address');
            $table->string('bank_zip');
            $table->string('bank_phone');
            $table->string('beneficiary_address');
            $table->string('beneficiary_zip')->nullable();
            $table->string('sort_code');
            $table->string('swift_code');
            $table->string('iban_number');
            $table->string('currency');
            $table->string('bic_number')->nullable();
            $table->string('reference')->nullable();

            $table->dropColumn('zelle_account');
            $table->dropColumn('paypal_username');
            $table->dropColumn('cashapp_username');
            $table->dropColumn('venmo_username');
        });
    }
}

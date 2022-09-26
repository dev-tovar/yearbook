<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUserTabblePrivacySettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('phone_privacy')->default(1);
            $table->integer('email_privacy')->default(1);
            $table->integer('gps_privacy')->default(1);
            $table->integer('career_privacy')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone_privacy');
            $table->dropColumn('email_privacy');
            $table->dropColumn('gps_privacy');
            $table->dropColumn('career_privacy');
        });
    }
}

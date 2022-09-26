<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersYearBooksFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_year_books', function (Blueprint $table) {
            $table->string('grade_level')->index();
            $table->string('confirmation_code')->nullable();
            $table->string('status')->default('not_paid');
            $table->string('avatar')->nullable();
            $table->dateTime('buyed_yearbook_at')->nullable();
            $table->string('app_status')->default('not active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_year_books', function (Blueprint $table) {
            $table->dropColumn('grade_level');
            $table->dropColumn('confirmation_code');
            $table->dropColumn('status');
            $table->dropColumn('avatar');
            $table->dropColumn('buyed_yearbook_at');
            $table->dropColumn('app_status');
        });
    }
}

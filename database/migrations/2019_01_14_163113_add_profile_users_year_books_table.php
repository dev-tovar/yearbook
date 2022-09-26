<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfileUsersYearBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_year_books', function (Blueprint $table) {
            $table->text('fecebook_link')->nullable();
            $table->text('linkedin_link')->nullable();
            $table->text('twitter_link')->nullable();
            $table->text('instagram_link')->nullable();
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
            $table->dropColumn('fecebook_link');
            $table->dropColumn('linkedin_link');
            $table->dropColumn('twitter_link');
            $table->dropColumn('instagram_link');
        });
    }
}

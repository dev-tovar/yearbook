<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAlumniFirldsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('alumni_email')->nullable();
            $table->string('alumni_phone')->nullable();
            $table->boolean('is_gps')->default(false);
            $table->string('alumni_address')->nullable();
            $table->string('fecebook_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('instagram_link')->nullable();
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
            $table->dropColumn('alumni_email');
            $table->dropColumn('alumni_phone');
            $table->dropColumn('is_gps');
            $table->dropColumn('alumni_address');
            $table->dropColumn('fecebook_link');
            $table->dropColumn('linkedin_link');
            $table->dropColumn('twitter_link');
            $table->dropColumn('instagram_link');
        });
    }
}

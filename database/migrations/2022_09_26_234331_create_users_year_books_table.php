<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersYearBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_year_books', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('yearbook_id');
            $table->timestamps();
            $table->string('grade_level')->index();
            $table->string('confirmation_code')->nullable();
            $table->string('status')->default('not_paid');
            $table->string('avatar')->nullable();
            $table->dateTime('buyed_yearbook_at')->nullable();
            $table->string('app_status')->default('not active');
            $table->boolean('is_buy')->default(false);
            $table->text('facebook_link')->nullable();
            $table->text('linkedin_link')->nullable();
            $table->text('twitter_link')->nullable();
            $table->text('instagram_link')->nullable();
            $table->text('photo_video')->nullable();
            $table->boolean('is_alumni')->default(false);
            $table->boolean('is_faculty')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_year_books');
    }
}

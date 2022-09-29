<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email', 191)->nullable()->unique();
            $table->string('password', 191)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->string('uuid', 191)->nullable()->unique();
            $table->boolean('is_admin')->default(false);
            $table->enum('user_type', ['student', 'parent', 'admin'])->default('student');
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->timestamp('registered_at')->nullable();
            $table->string('ios_token')->nullable();
            $table->string('android_token')->nullable();
            $table->boolean('is_push_notification')->default(true);
            $table->boolean('is_email_notification')->default(true);
            $table->boolean('is_tmp')->default(true);
            $table->string('alumni_email')->nullable();
            $table->string('alumni_phone')->nullable();
            $table->boolean('is_gps')->default(false);
            $table->string('alumni_address')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->integer('phone_privacy')->default(1);
            $table->integer('email_privacy')->default(1);
            $table->integer('gps_privacy')->default(1);
            $table->integer('career_privacy')->default(1);
            $table->string('company')->nullable();
            $table->boolean('blocked')->default(false);
            $table->text('sports')->nullable();
            $table->boolean('is_school_admin')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

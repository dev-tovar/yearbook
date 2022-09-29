<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareerUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('career_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('career_id')->index('career_user_career_id_foreign');
            $table->unsignedInteger('user_id')->index('career_user_user_id_foreign');
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
        Schema::dropIfExists('career_user');
    }
}

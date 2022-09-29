<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFutureAttendingUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('future_attending_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('future_attending_id')->index('future_attending_user_future_attending_id_foreign');
            $table->unsignedInteger('user_id')->index('future_attending_user_user_id_foreign');
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
        Schema::dropIfExists('future_attending_user');
    }
}

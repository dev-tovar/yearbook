<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePushHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index('push_histories_user_id_foreign');
            $table->text('title');
            $table->string('image')->nullable();
            $table->timestamps();
            $table->boolean('is_read')->default(false);
            $table->string('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('push_histories');
    }
}

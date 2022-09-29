<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_views', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index('feed_views_user_id_foreign');
            $table->unsignedInteger('feed_id')->index('feed_views_feed_id_foreign');
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
        Schema::dropIfExists('feed_views');
    }
}

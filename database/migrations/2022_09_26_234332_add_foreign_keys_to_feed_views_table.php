<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToFeedViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feed_views', function (Blueprint $table) {
            $table->foreign(['feed_id'])->references(['id'])->on('feeds')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feed_views', function (Blueprint $table) {
            $table->dropForeign('feed_views_feed_id_foreign');
            $table->dropForeign('feed_views_user_id_foreign');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToFeedGradeLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feed_grade_levels', function (Blueprint $table) {
            $table->foreign(['feed_id'])->references(['id'])->on('feeds')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feed_grade_levels', function (Blueprint $table) {
            $table->dropForeign('feed_grade_levels_feed_id_foreign');
        });
    }
}

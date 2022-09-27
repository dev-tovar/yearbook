<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToFeedAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feed_attachments', function (Blueprint $table) {
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
        Schema::table('feed_attachments', function (Blueprint $table) {
            $table->dropForeign('feed_attachments_feed_id_foreign');
        });
    }
}

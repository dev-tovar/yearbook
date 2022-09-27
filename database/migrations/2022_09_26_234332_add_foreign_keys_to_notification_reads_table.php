<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToNotificationReadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notification_reads', function (Blueprint $table) {
            $table->foreign(['notification_id'])->references(['id'])->on('push_histories')->onUpdate('NO ACTION')->onDelete('CASCADE');
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
        Schema::table('notification_reads', function (Blueprint $table) {
            $table->dropForeign('notification_reads_notification_id_foreign');
            $table->dropForeign('notification_reads_user_id_foreign');
        });
    }
}

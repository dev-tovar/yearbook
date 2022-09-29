<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToYearbookNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('yearbook_notifications', function (Blueprint $table) {
            $table->foreign(['from_user_id'])->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['wall_id'])->references(['id'])->on('walls')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['yearbook_id'])->references(['id'])->on('year_books')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('yearbook_notifications', function (Blueprint $table) {
            $table->dropForeign('yearbook_notifications_from_user_id_foreign');
            $table->dropForeign('yearbook_notifications_user_id_foreign');
            $table->dropForeign('yearbook_notifications_wall_id_foreign');
            $table->dropForeign('yearbook_notifications_yearbook_id_foreign');
        });
    }
}

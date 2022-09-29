<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEventVisitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_visit', function (Blueprint $table) {
            $table->foreign(['event_id'])->references(['id'])->on('alumni_events')->onUpdate('NO ACTION')->onDelete('CASCADE');
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
        Schema::table('event_visit', function (Blueprint $table) {
            $table->dropForeign('event_visit_event_id_foreign');
            $table->dropForeign('event_visit_user_id_foreign');
        });
    }
}

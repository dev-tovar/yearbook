<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEventsLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events_levels', function (Blueprint $table) {
            $table->foreign(['event_id'])->references(['id'])->on('alumni_events')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events_levels', function (Blueprint $table) {
            $table->dropForeign('events_levels_event_id_foreign');
        });
    }
}

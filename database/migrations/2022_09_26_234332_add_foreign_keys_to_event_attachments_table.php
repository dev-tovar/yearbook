<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEventAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_attachments', function (Blueprint $table) {
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
        Schema::table('event_attachments', function (Blueprint $table) {
            $table->dropForeign('event_attachments_event_id_foreign');
        });
    }
}

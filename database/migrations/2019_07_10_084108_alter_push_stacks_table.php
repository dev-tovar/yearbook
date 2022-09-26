<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPushStacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('push_stacks', function (Blueprint $table) {
//            $table->unsignedInteger('push_id');
//            $table->string('push_type');
            $table->morphs('pushable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('push_stacks', function (Blueprint $table) {
//            $table->dropColumn('push_id');
//            $table->dropColumn('push_type');
            $table->dropColumn('pushable');
        });
    }
}

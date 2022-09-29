<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventVisitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_visit', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index('event_visit_user_id_foreign');
            $table->unsignedInteger('event_id')->index('event_visit_event_id_foreign');
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('event_visit');
    }
}

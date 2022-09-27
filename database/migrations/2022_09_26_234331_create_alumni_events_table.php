<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumniEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumni_events', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('school_id')->index();
            $table->string('title');
            $table->text('message')->nullable();
            $table->string('link')->nullable();
            $table->integer('recipients')->default(0);
            $table->text('attach')->nullable();
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
        Schema::dropIfExists('alumni_events');
    }
}

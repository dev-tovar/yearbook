<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePushStacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_stacks', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('custom')->nullable();
            $table->text('recipient');
            $table->timestamps();
            $table->string('device');
            $table->softDeletes();
            $table->string('image')->nullable();
            $table->string('pushable_type');
            $table->unsignedBigInteger('pushable_id');

            $table->index(['pushable_type', 'pushable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('push_stacks');
    }
}

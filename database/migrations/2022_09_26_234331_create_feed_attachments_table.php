<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('feed_id')->index();
            $table->string('original_name');
            $table->integer('size')->default(0);
            $table->string('mime')->nullable();
            $table->string('path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_attachments');
    }
}

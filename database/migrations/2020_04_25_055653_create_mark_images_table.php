<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarkImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mark_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path');
            $table->string('src')->unique();
            $table->string('type');
            $table->unsignedInteger('who_mark');
            $table->unsignedInteger('marked');
            $table->tinyInteger('confirm')->default(0);
            $table->timestamps();

            $table->foreign('who_mark')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('marked')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->index('src');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mark_images');
    }
}

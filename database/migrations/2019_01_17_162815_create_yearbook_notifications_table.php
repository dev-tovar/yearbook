<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYearbookNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yearbook_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message')->nullable();
            $table->string('type');
            $table->boolean('is_dot');
            $table->boolean('is_read');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->integer('from_user_id')->unsigned();
            $table->foreign('from_user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->integer('yearbook_id')->unsigned();
            $table->foreign('yearbook_id')->references('id')->on('year_books')
                ->onDelete('cascade');
            $table->integer('wall_id')->unsigned()->nullable();
            $table->foreign('wall_id')->references('id')->on('walls')
                ->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('yearbook_notifications');
    }
}

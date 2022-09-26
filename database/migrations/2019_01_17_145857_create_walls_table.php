<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('walls', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message')->nullable();
            $table->string('status')->default('pending')
                ->comment('pending,approve,decline');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->integer('from_user_id')->unsigned();
            $table->foreign('from_user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->integer('yearbook_id')->unsigned();
            $table->foreign('yearbook_id')->references('id')->on('year_books')
                ->onDelete('cascade');
            $table->dateTime('approve_date')->nullable();
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
        Schema::dropIfExists('walls');
    }
}

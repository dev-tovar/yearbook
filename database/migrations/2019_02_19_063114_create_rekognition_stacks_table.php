<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRekognitionStacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekognition_stacks', function (Blueprint $table) {
            $table->increments('id');
            $table->text('source');
            $table->text('target');
            $table->integer('users_year_book_id')->unsigned();
            $table->foreign('users_year_book_id')->references('id')->on('users_year_books')
                ->onDelete('cascade');
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
        Schema::dropIfExists('rekognition_stacks');
    }
}

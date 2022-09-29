<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->unsignedInteger('users_year_book_id')->index('rekognition_stacks_users_year_book_id_foreign');
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

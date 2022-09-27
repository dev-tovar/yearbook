<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToRekognitionStacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekognition_stacks', function (Blueprint $table) {
            $table->foreign(['users_year_book_id'])->references(['id'])->on('users_year_books')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rekognition_stacks', function (Blueprint $table) {
            $table->dropForeign('rekognition_stacks_users_year_book_id_foreign');
        });
    }
}

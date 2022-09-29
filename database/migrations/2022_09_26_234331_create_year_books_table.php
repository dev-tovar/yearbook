<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('year_books', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id');
            $table->year('year_from');
            $table->year('year_to');
            $table->softDeletes();
            $table->timestamps();
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->boolean('is_student_tribute')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('year_books');
    }
}

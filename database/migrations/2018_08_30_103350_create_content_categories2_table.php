<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentCategories2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('can_edit')->default(true);
            $table->integer('year_book_id')->unsigned()->nullable();
            $table->foreign('year_book_id')->references('id')->on('year_books')->onDelete('cascade');
            $table->integer('parent_category_id')->unsigned()->nullable();
            $table->foreign('parent_category_id')->references('id')->on('content_categories')->onDelete('cascade');
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
        Schema::dropIfExists('content_categories');
    }
}

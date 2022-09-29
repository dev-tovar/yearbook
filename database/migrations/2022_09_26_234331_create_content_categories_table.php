<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentCategoriesTable extends Migration
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
            $table->unsignedInteger('year_book_id')->nullable()->index('content_categories_year_book_id_foreign');
            $table->unsignedInteger('parent_category_id')->nullable()->index('content_categories_parent_category_id_foreign');
            $table->timestamps();
            $table->integer('position')->default(0);
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

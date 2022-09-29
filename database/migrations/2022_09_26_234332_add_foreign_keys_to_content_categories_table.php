<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToContentCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('content_categories', function (Blueprint $table) {
            $table->foreign(['parent_category_id'])->references(['id'])->on('content_categories')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['year_book_id'])->references(['id'])->on('year_books')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('content_categories', function (Blueprint $table) {
            $table->dropForeign('content_categories_parent_category_id_foreign');
            $table->dropForeign('content_categories_year_book_id_foreign');
        });
    }
}

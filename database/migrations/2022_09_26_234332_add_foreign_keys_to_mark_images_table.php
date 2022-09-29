<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToMarkImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mark_images', function (Blueprint $table) {
            $table->foreign(['marked'])->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['who_mark'])->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['yearbook_id'])->references(['id'])->on('year_books')->onUpdate('NO ACTION')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mark_images', function (Blueprint $table) {
            $table->dropForeign('mark_images_marked_foreign');
            $table->dropForeign('mark_images_who_mark_foreign');
            $table->dropForeign('mark_images_yearbook_id_foreign');
        });
    }
}

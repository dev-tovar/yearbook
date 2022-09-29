<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPageContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_contents', function (Blueprint $table) {
            $table->foreign(['field_id'])->references(['id'])->on('template_fields')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['page_id'])->references(['id'])->on('pages')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('page_contents', function (Blueprint $table) {
            $table->dropForeign('page_contents_field_id_foreign');
            $table->dropForeign('page_contents_page_id_foreign');
        });
    }
}

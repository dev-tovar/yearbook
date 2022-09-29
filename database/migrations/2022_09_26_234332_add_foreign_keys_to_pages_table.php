<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->foreign(['category_id'])->references(['id'])->on('content_categories')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['template_id'])->references(['id'])->on('templates')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign('pages_category_id_foreign');
            $table->dropForeign('pages_template_id_foreign');
            $table->dropForeign('pages_user_id_foreign');
        });
    }
}

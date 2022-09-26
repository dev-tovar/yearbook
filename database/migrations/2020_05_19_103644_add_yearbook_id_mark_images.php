<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddYearbookIdMarkImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mark_images', function (Blueprint $table) {
            $table->unsignedInteger('yearbook_id')->nullable()->after('marked');

            $table->foreign('yearbook_id')
                ->references('id')
                ->on('year_books')
                ->onDelete('set null');
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
            $table->dropColumn('yearbook_id');
        });
    }
}

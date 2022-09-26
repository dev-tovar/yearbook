<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOcialSettingsSchollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->boolean('is_fb')->default(true);
            $table->boolean('is_twitter')->default(true);
            $table->boolean('is_inst')->default(true);
            $table->boolean('is_linkedin')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn('is_fb');
            $table->dropColumn('is_twitter');
            $table->dropColumn('is_inst');
            $table->dropColumn('is_linkedin');
        });
    }
}

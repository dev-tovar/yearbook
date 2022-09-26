<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyFecebookField extends Migration
{
    public function __construct()
    {
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('fecebook_link', 'facebook_link');
        });

        Schema::table('users_year_books', function (Blueprint $table) {
            $table->renameColumn('fecebook_link', 'facebook_link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('facebook_link', 'fecebook_link');
        });

        Schema::table('users_year_books', function (Blueprint $table) {
            $table->renameColumn('facebook_link', 'fecebook_link');
        });
    }
}

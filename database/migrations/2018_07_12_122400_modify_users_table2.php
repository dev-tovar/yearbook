<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUsersTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        \Illuminate\Support\Facades\DB::statement(
            "ALTER TABLE `users` CHANGE `uuid` `uuid` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL"
        );
        \Illuminate\Support\Facades\DB::statement(
            "ALTER TABLE `users` CHANGE `school_id` `school_id` INT(11) NULL;"
        );
        \Illuminate\Support\Facades\DB::statement(
            "ALTER TABLE `users` CHANGE `grade_level` `grade_level` INT(11) NULL;"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

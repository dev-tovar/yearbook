<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCareerUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('career_user', function (Blueprint $table) {
            $table->foreign(['career_id'])->references(['id'])->on('careers')->onUpdate('NO ACTION')->onDelete('CASCADE');
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
        Schema::table('career_user', function (Blueprint $table) {
            $table->dropForeign('career_user_career_id_foreign');
            $table->dropForeign('career_user_user_id_foreign');
        });
    }
}

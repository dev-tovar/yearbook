<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToFutureAspirationUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('future_aspiration_user', function (Blueprint $table) {
            $table->foreign(['future_aspiration_id'])->references(['id'])->on('future_aspirations')->onUpdate('NO ACTION')->onDelete('CASCADE');
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
        Schema::table('future_aspiration_user', function (Blueprint $table) {
            $table->dropForeign('future_aspiration_user_future_aspiration_id_foreign');
            $table->dropForeign('future_aspiration_user_user_id_foreign');
        });
    }
}

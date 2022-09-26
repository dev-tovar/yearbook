<?php

use App\Enums\AlumniPushType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyAlumniPushHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumni_push_histories', function (Blueprint $table) {
            $table->tinyInteger('message_type')->default(AlumniPushType::Standart);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alumni_push_histories', function (Blueprint $table) {
            $table->dropColumn('message_type');
        });
    }
}

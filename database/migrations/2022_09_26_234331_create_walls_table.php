<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('walls', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message')->nullable();
            $table->string('status')->default('pending')->comment('pending,approve,decline');
            $table->unsignedInteger('user_id')->index('walls_user_id_foreign');
            $table->unsignedInteger('from_user_id')->index('walls_from_user_id_foreign');
            $table->unsignedInteger('yearbook_id')->index('walls_yearbook_id_foreign');
            $table->dateTime('approve_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('walls');
    }
}

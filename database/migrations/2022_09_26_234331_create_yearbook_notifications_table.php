<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearbookNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yearbook_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message')->nullable();
            $table->string('type');
            $table->boolean('is_dot');
            $table->boolean('is_read');
            $table->unsignedInteger('user_id')->index('yearbook_notifications_user_id_foreign');
            $table->unsignedInteger('from_user_id')->index('yearbook_notifications_from_user_id_foreign');
            $table->unsignedInteger('yearbook_id')->index('yearbook_notifications_yearbook_id_foreign');
            $table->unsignedInteger('wall_id')->nullable()->index('yearbook_notifications_wall_id_foreign');
            $table->text('data')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->boolean('is_action')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yearbook_notifications');
    }
}

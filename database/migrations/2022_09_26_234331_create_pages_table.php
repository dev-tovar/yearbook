<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_publish')->default(false);
            $table->boolean('is_app_publish')->default(false);
            $table->unsignedInteger('template_id')->index('pages_template_id_foreign');
            $table->unsignedInteger('category_id')->index('pages_category_id_foreign');
            $table->timestamps();
            $table->integer('position')->default(0);
            $table->unsignedInteger('user_id')->nullable()->index('pages_user_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mark_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path');
            $table->string('src')->index();
            $table->string('type');
            $table->unsignedInteger('who_mark')->index('mark_images_who_mark_foreign');
            $table->unsignedInteger('marked')->index('mark_images_marked_foreign');
            $table->unsignedInteger('yearbook_id')->nullable()->index('mark_images_yearbook_id_foreign');
            $table->tinyInteger('confirm')->default(0);
            $table->boolean('is_confirm')->default(false);
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
        Schema::dropIfExists('mark_images');
    }
}

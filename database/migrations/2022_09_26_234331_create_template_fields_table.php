<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('name');
            $table->integer('position');
            $table->string('title');
            $table->unsignedInteger('template_id')->index('template_fields_template_id_foreign');
            $table->integer('limits')->default(-1);
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
        Schema::dropIfExists('template_fields');
    }
}

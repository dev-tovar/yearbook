<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('school_id')->index();
            $table->string('title');
            $table->text('message')->nullable();
            $table->string('link', 191)->nullable();
            $table->timestamps();
            $table->enum('recipients', ['gradelevel', 'students', 'parents', 'everyone'])->default('everyone');
            $table->text('attach')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feeds');
    }
}

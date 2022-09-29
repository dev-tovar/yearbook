<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('grade')->nullable();
            $table->integer('students_number')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zip')->nullable();
            $table->string('address');
            $table->string('advisor')->nullable();
            $table->enum('status', ['paid', 'not_paid'])->default('not_paid');
            $table->softDeletes();
            $table->timestamps();
            $table->integer('contract_years')->default(1);
            $table->date('contract_start_date')->nullable();
            $table->boolean('is_fb')->default(true);
            $table->boolean('is_twitter')->default(true);
            $table->boolean('is_inst')->default(true);
            $table->boolean('is_linkedin')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schools');
    }
}

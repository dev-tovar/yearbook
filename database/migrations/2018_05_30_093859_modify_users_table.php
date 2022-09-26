<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->integer('school_id');
            $table->integer('grade_level');
            $table->string('uuid')->unique();
            $table->string('confirmation_code');
            $table->boolean('is_admin')->default(0);
            $table->tinyInteger('role_id');
            $table->enum('status', [
                'paid',
                'not_paid'
            ]);

            $table->index('role_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

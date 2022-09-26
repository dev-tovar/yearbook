<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteYearbookRowsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('grade_level');
            $table->dropColumn('confirmation_code');
            $table->dropColumn('status');
            $table->dropColumn('avatar');
            $table->dropColumn('buyed_yearbook_at');
            $table->dropColumn('app_status');
            $table->dropColumn('school_id');
            $table->dropColumn('school_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('school_id');
            $table->string('grade_level');
            $table->string('confirmation_code');
            $table->enum('status', [
                'paid',
                'not_paid'
            ]);
            $table->text('school_name')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamp('buyed_yearbook_at')->nullable();
            $table->string('app_status')->default('not active');
        });
    }
}

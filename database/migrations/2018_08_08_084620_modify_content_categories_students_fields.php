<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyContentCategoriesStudentsFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::table('content_categories', function (Blueprint $table) {
	    	$table->boolean('students')->defautl(false);
	    	$table->boolean('vip')->defautl(false);
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('content_categories', function (Blueprint $table) {
		    //
		    $table->dropColumn('students');
		    $table->dropColumn('vip');
	    });
    }
}

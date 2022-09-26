<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePageElements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_content_elements', function (Blueprint $table) {
            //
	        $table->integer('page_id');
	        $table->string('field_type');
	        $table->text('field_value');
	        $table->integer('position');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('page_content_elements', function (Blueprint $table) {
            //
	        $table->dropColumn('page_id');
	        $table->dropColumn('field_type');
	        $table->dropColumn('field_value');
	        $table->dropColumn('position');
        });
    }
}

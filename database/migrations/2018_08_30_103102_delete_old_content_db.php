<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteOldContentDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('content_books');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('page_content_elements');
        Schema::dropIfExists('sub_categories');
        Schema::dropIfExists('templates');
        Schema::dropIfExists('template_fields');
        Schema::dropIfExists('content_categories');
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

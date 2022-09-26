<?php

use App\Enums\EventsVisitStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitAlumniEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $dbSchemaManager = Schema::getConnection()->getDoctrineSchemaManager();
        foreach ($dbSchemaManager->listTableNames() as $tableName) {
            DB::statement(sprintf('ALTER TABLE %s ENGINE = InnoDB', $tableName));
        }

        Schema::create('event_visit', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('event_id');
            $table->tinyInteger('status')->default(EventsVisitStatus::NEW);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('alumni_events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_visit');
    }
}

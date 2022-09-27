<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGradePositionFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::unprepared("
CREATE FUNCTION gradePosition(grade varchar(191)) RETURNS INT
BEGIN
DECLARE res INT;

IF grade = \"Pre-Kindergarten\" THEN
	SET res = 1;
ELSEIF grade = \"Kindergarten\" THEN
	SET res = 2;
ELSEIF grade = \"PK(pre-kindergarten)\" THEN
	SET res = 1;
ELSEIF grade = \"K(kindergarten)\" THEN
	SET res = 2;
ELSEIF grade = \"\" THEN
	SET res = 0;
ELSE
	SET res = CAST(grade AS UNSIGNED) + 2;
END IF;
RETURN res;
END");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::unprepared("DROP FUNCTION IF EXISTS gradePosition;");
    }
}

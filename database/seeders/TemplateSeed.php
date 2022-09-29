<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TemplateSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('templates')->delete();

        $this->call(CoverTemplateSeed::class);
        $this->call(DefaultTemplateSeed::class);
        $this->call(GradeTemplateSeed::class);
        $this->call(StudentProfileTemplateSeed::class);
        $this->call(StudentTributeTemplateSeed::class);
    }
}

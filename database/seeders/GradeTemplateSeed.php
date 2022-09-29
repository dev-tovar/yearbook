<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class GradeTemplateSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template_1 = \App\Models\Template::create([
            'name' => 'Default Grade Template',
            'category_name' => 'Grades'
        ]);

        $template_1->fields()->create([
            'type' => 'grade_user',
            'name' => 'grade_user[]',
            'position' => 1,
            'title' => ""
        ]);
    }
}

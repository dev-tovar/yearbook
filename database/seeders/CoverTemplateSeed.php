<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class CoverTemplateSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template_1 = \App\Models\Template::create([
            'name'          => 'Template 1',
            'category_name' => 'Cover',
        ]);

        $template_1->fields()->create([
            'type'     => 'string',
            'name'     => 'title',
            'position' => 1,
            'title'    => "Title",
            'limits'   => 50,
        ]);

        $template_1->fields()->create([
            'type'     => 'image',
            'name'     => 'image',
            'position' => 2,
            'title'    => "Image",
        ]);

        $template_1->fields()->create([
            'type'     => 'text',
            'name'     => 'text',
            'position' => 3,
            'title'    => "Text",
            'limits'   => 200,
        ]);


        $template_2 = \App\Models\Template::create([
            'name'          => 'Template 2',
            'category_name' => 'Cover',
        ]);

        $template_2->fields()->create([
            'type'     => 'image',
            'name'     => 'image',
            'position' => 1,
            'title'    => "Image",
        ]);


        $template_3 = \App\Models\Template::create([
            'name'          => 'Template 3',
            'category_name' => 'Cover',
        ]);

        $template_3->fields()->create([
            'type'     => 'image',
            'name'     => 'image',
            'position' => 1,
            'title'    => "Image",
        ]);

        $template_3->fields()->create([
            'type'     => 'string',
            'name'     => 'title',
            'position' => 2,
            'title'    => "Title",
            'limits'   => 50,
        ]);

        $template_3->fields()->create([
            'type'     => 'text',
            'name'     => 'text',
            'position' => 3,
            'title'    => "Text",
            'limits'   => 200,
        ]);
    }
}

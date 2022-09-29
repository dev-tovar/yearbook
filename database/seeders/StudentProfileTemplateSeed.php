<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class StudentProfileTemplateSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template_1 = \App\Models\Template::create([
            'name'          => 'Default Students Profile Template',
            'category_name' => 'Students Profile',
        ]);

        $template_1->fields()->create([
            'type'     => 'two_images',
            'name'     => 'additional_photos',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Additional Photos",
        ]);

        $template_1->fields()->create([
            'type'     => 'string',
            'name'     => 'senior_quote',
            'position' => 2,
            'limits'   => 100,
            'title'    => "Senior quote",
        ]);

        $template_1->fields()->create([
            'type'     => 'string',
            'name'     => 'sports_clubs',
            'position' => 3,
            'limits'   => 100,
            'title'    => "Sports/Clubs",
        ]);

        $template_1->fields()->create([
            'type'     => 'string',
            'name'     => 'future_attending',
            'position' => 4,
            'limits'   => 100,
            'title'    => "College Attending",
        ]);

        $template_1->fields()->create([
            'type'     => 'string',
            'name'     => 'future_aspirations',
            'position' => 5,
            'limits'   => 100,
            'title'    => "Future Aspirations",
        ]);
    }
}

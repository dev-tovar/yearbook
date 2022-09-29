<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class StudentTributeTemplateSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /** @var \App\Models\Template $template_basic_3 */
        $template_basic_3 = \App\Models\Template::create([
            'name'          => 'Template 3',
            'category_name' => 'Student Tribute Basic',
        ]);

        $template_basic_3->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 0,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_basic_3->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_basic_3->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_1',
            'position' => 2,
            'title'    => "Video",
        ]);

        $template_basic_3->fields()->create([
            'type'     => 'text',
            'name'     => 'text_1',
            'position' => 3,
            'title'    => "Text",
        ]);

        /** @var \App\Models\Template $template_basic_2 */
        $template_basic_2 = \App\Models\Template::create([
            'name'          => 'Template 2',
            'category_name' => 'Student Tribute Basic',
        ]);

        $template_basic_2->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 0,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_basic_2->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_1',
            'position' => 1,
            'title'    => "Video",
        ]);

        $template_basic_2->fields()->create([
            'type'     => 'text',
            'name'     => 'text_1',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_basic_2->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images',
            'position' => 3,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);


        /** @var \App\Models\Template $template_basic_1 */
        $template_basic_1 = \App\Models\Template::create([
            'name'          => 'Template 1',
            'category_name' => 'Student Tribute Basic',
        ]);

        $template_basic_1->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 0,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_basic_1->fields()->create([
            'type'     => 'text',
            'name'     => 'text_1',
            'position' => 1,
            'title'    => "Text",
        ]);

        $template_basic_1->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery',
            'position' => 2,
            'limits'   => 2,
            'title'    => "Gallery",
        ]);
        $template_basic_1->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_1',
            'position' => 3,
            'title'    => "Video",
        ]);


        /** @var \App\Models\Template $template_premium_5 */
        $template_premium_5 = \App\Models\Template::create([
            'name'          => 'Template 5',
            'category_name' => 'Student Tribute Premium',
        ]);

        $template_premium_5->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 0,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_premium_5->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery',
            'position' => 1,
            'limits'   => 4,
            'title'    => "Gallery",
        ]);

        $template_premium_5->fields()->create([
            'type'     => 'text',
            'name'     => 'text_1',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_premium_5->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images',
            'position' => 3,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        /** @var \App\Models\Template $template_premium_4 */
        $template_premium_4 = \App\Models\Template::create([
            'name'          => 'Template 4',
            'category_name' => 'Student Tribute Premium',
        ]);

        $template_premium_4->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 0,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_premium_4->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_1',
            'position' => 1,
            'title'    => "Image",
        ]);

        $template_premium_4->fields()->create([
            'type'     => 'three_images',
            'name'     => 'three_images',
            'position' => 2,
            'limits'   => 100,
            'title'    => "Three Images",
        ]);

        $template_premium_4->fields()->create([
            'type'     => 'text',
            'name'     => 'text_1',
            'position' => 3,
            'title'    => "Text",
        ]);

        $template_premium_4->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images',
            'position' => 4,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        /** @var \App\Models\Template $template_premium_2 */
        $template_premium_2 = \App\Models\Template::create([
            'name'          => 'Template 2',
            'category_name' => 'Student Tribute Premium',
        ]);

        $template_premium_2->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 0,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_premium_2->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_premium_2->fields()->create([
            'type'     => 'text',
            'name'     => 'text_1',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_premium_2->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery',
            'position' => 3,
            'limits'   => 4,
            'title'    => "Gallery",
        ]);

        /** @var \App\Models\Template $template_premium_1 */
        $template_premium_1 = \App\Models\Template::create([
            'name'          => 'Template 1',
            'category_name' => 'Student Tribute Premium',
        ]);

        $template_premium_1->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 0,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_premium_1->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_1',
            'position' => 1,
            'title'    => "Image",
        ]);

        $template_premium_1->fields()->create([
            'type'     => 'text',
            'name'     => 'text_1',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_premium_1->fields()->create([
            'type'     => 'three_images',
            'name'     => 'three_images',
            'position' => 3,
            'limits'   => 100,
            'title'    => "Three Images",
        ]);

        $template_premium_1->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images',
            'position' => 4,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        /** @var \App\Models\Template $template_premium_3 */
        $template_premium_3 = \App\Models\Template::create([
            'name'          => 'Template 3',
            'category_name' => 'Student Tribute Premium',
        ]);

        $template_premium_3->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 0,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_premium_3->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_premium_3->fields()->create([
            'type'     => 'text',
            'name'     => 'text_1',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_premium_3->fields()->create([
            'type'     => 'four_images',
            'name'     => 'four_images',
            'position' => 3,
            'limits'   => 100,
            'title'    => "Four Images",
        ]);
    }
}

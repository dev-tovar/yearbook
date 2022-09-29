<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DefaultTemplateSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var \App\Models\Template $template_3 */
        $template_2 = \App\Models\Template::create([
            'name' => 'Template 2',
        ]);

        $template_2->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_2->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_2',
            'position' => 2,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_2->fields()->create([
            'type'     => 'text',
            'name'     => 'text_3',
            'position' => 3,
            'title'    => "Text",
        ]);

        $template_2->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_4',
            'position' => 4,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_2->fields()->create([
            'type'     => 'text',
            'name'     => 'text_6',
            'position' => 6,
            'title'    => "Text",
        ]);

        $template_2->fields()->create([
            'type'     => 'string',
            'name'     => 'link_7',
            'position' => 7,
            'title'    => "Link",
        ]);

        $template_2->fields()->create([
            'type'     => 'string',
            'name'     => 'title_8',
            'position' => 8,
            'title'    => "Title",
        ]);

        $template_2->fields()->create([
            'type'     => 'text',
            'name'     => 'text_9',
            'position' => 9,
            'title'    => "Text",
        ]);

        $template_2->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_10',
            'position' => 10,
            'title'    => "Video",
        ]);

        $template_2->fields()->create([
            'type'     => 'text',
            'name'     => 'text_11',
            'position' => 11,
            'title'    => "Text",
        ]);

        $template_2->fields()->create([
            'type'     => 'string',
            'name'     => 'link_12',
            'position' => 12,
            'title'    => "Link",
        ]);












        /** @var \App\Models\Template $template_3 */
        $template_3 = \App\Models\Template::create([
            'name' => 'Template 3',
        ]);

        $template_3->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_1',
            'position' => 1,
            'title'    => "Image",
        ]);

        $template_3->fields()->create([
            'type'     => 'string',
            'name'     => 'title_2',
            'position' => 2,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_3->fields()->create([
            'type'     => 'text',
            'name'     => 'text_3',
            'position' => 3,
            'title'    => "Text",
        ]);

        $template_3->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_4',
            'position' => 4,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_3->fields()->create([
            'type'     => 'text',
            'name'     => 'text_6',
            'position' => 6,
            'title'    => "Text",
        ]);

        $template_3->fields()->create([
            'type'     => 'string',
            'name'     => 'title_7',
            'position' => 7,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_3->fields()->create([
            'type'     => 'text',
            'name'     => 'text_8',
            'position' => 8,
            'title'    => "Text",
        ]);

        $template_3->fields()->create([
            'type'     => 'string',
            'name'     => 'link_9',
            'position' => 9,
            'title'    => "Link",
        ]);

        $template_3->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_10',
            'position' => 10,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_3->fields()->create([
            'type'     => 'text',
            'name'     => 'text_11',
            'position' => 11,
            'title'    => "Text",
        ]);













        /** @var \App\Models\Template $template_4 */
        $template_4 = \App\Models\Template::create([
            'name' => 'Template 4',
        ]);

        $template_4->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_4->fields()->create([
            'type'     => 'text',
            'name'     => 'text_2',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_4->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_3',
            'position' => 3,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_4->fields()->create([
            'type'     => 'text',
            'name'     => 'text_4',
            'position' => 4,
            'title'    => "Text",
        ]);

        $template_4->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_5',
            'position' => 5,
            'title'    => "Video",
        ]);

        $template_4->fields()->create([
            'type'     => 'string',
            'name'     => 'link_6',
            'position' => 6,
            'title'    => "Link",
        ]);

        $template_4->fields()->create([
            'type'     => 'string',
            'name'     => 'title_7',
            'position' => 7,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_4->fields()->create([
            'type'     => 'text',
            'name'     => 'text_8',
            'position' => 8,
            'title'    => "Text",
        ]);

        $template_4->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_9',
            'position' => 9,
            'title'    => "Image",
        ]);

        $template_4->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_10',
            'position' => 10,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_4->fields()->create([
            'type'     => 'text',
            'name'     => 'text_12',
            'position' => 12,
            'title'    => "Text",
        ]);









        /** @var \App\Models\Template $template_5 */
        $template_5 = \App\Models\Template::create([
            'name' => 'Template 5',
        ]);

        $template_5->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_5->fields()->create([
            'type'     => 'text',
            'name'     => 'text_2',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_5->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_3',
            'position' => 3,
            'title'    => "Image",
        ]);

        $template_5->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_4',
            'position' => 4,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_5->fields()->create([
            'type'     => 'string',
            'name'     => 'link_6',
            'position' => 6,
            'title'    => "Link",
        ]);

        $template_5->fields()->create([
            'type'     => 'string',
            'name'     => 'title_7',
            'position' => 7,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_5->fields()->create([
            'type'     => 'text',
            'name'     => 'text_8',
            'position' => 8,
            'title'    => "Text",
        ]);

        $template_5->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_9',
            'position' => 9,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_5->fields()->create([
            'type'     => 'text',
            'name'     => 'text_11',
            'position' => 11,
            'title'    => "Text",
        ]);

        $template_5->fields()->create([
            'type'     => 'string',
            'name'     => 'title_12',
            'limits'   => 100,
            'position' => 12,
            'title'    => "Title",
        ]);

        $template_5->fields()->create([
            'type'     => 'text',
            'name'     => 'text_13',
            'position' => 13,
            'title'    => "Text",
        ]);

        $template_5->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_14',
            'position' => 14,
            'title'    => "Video",
        ]);







        /** @var \App\Models\Template $template_6 */
        $template_6 = \App\Models\Template::create([
            'name' => 'Template 6',
        ]);

        $template_6->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_1',
            'position' => 1,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_6->fields()->create([
            'type'     => 'string',
            'name'     => 'link_2',
            'position' => 2,
            'title'    => "Link",
        ]);

        $template_6->fields()->create([
            'type'     => 'string',
            'name'     => 'title_3',
            'position' => 3,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_6->fields()->create([
            'type'     => 'text',
            'name'     => 'text_4',
            'position' => 4,
            'title'    => "Text",
        ]);

        $template_6->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_5',
            'position' => 5,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_6->fields()->create([
            'type'     => 'text',
            'name'     => 'text_7',
            'position' => 7,
            'title'    => "Text",
        ]);

        $template_6->fields()->create([
            'type'     => 'string',
            'name'     => 'title_8',
            'position' => 8,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_6->fields()->create([
            'type'     => 'text',
            'name'     => 'text_9',
            'position' => 9,
            'title'    => "Text",
        ]);

        $template_6->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_10',
            'position' => 10,
            'title'    => "Image",
        ]);

        $template_6->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_11',
            'position' => 11,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_6->fields()->create([
            'type'     => 'string',
            'name'     => 'link_13',
            'position' => 13,
            'title'    => "Link",
        ]);










        /** @var \App\Models\Template $template_7 */
        $template_7 = \App\Models\Template::create([
            'name' => 'Template 7',
        ]);

        $template_7->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_7->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_2',
            'position' => 2,
            'title'    => "Video",
        ]);

        $template_7->fields()->create([
            'type'     => 'string',
            'name'     => 'link_3',
            'position' => 3,
            'title'    => "Link",
        ]);

        $template_7->fields()->create([
            'type'     => 'text',
            'name'     => 'text_4',
            'position' => 4,
            'title'    => "Text",
        ]);

        $template_7->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_5',
            'position' => 5,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_7->fields()->create([
            'type'     => 'string',
            'name'     => 'title_7',
            'position' => 7,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_7->fields()->create([
            'type'     => 'text',
            'name'     => 'text_8',
            'position' => 8,
            'title'    => "Text",
        ]);

        $template_7->fields()->create([
            'type'     => 'string',
            'name'     => 'title_9',
            'position' => 9,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_7->fields()->create([
            'type'     => 'text',
            'name'     => 'text_10',
            'position' => 10,
            'title'    => "Text",
        ]);

        $template_7->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_11',
            'position' => 11,
            'title'    => "Image",
        ]);

        $template_7->fields()->create([
            'type'     => 'text',
            'name'     => 'text_12',
            'position' => 12,
            'title'    => "Text",
        ]);







        /** @var \App\Models\Template $template_8 */
        $template_8 = \App\Models\Template::create([
            'name' => 'Template 8',
        ]);

        $template_8->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_8->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_2',
            'position' => 2,
            'title'    => "Image",
        ]);

        $template_8->fields()->create([
            'type'     => 'string',
            'name'     => 'link_3',
            'position' => 3,
            'title'    => "Link",
        ]);

        $template_8->fields()->create([
            'type'     => 'text',
            'name'     => 'text_4',
            'position' => 4,
            'title'    => "Text",
        ]);

        $template_8->fields()->create([
            'type'     => 'string',
            'name'     => 'title_5',
            'position' => 5,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_8->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_6',
            'position' => 6,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_8->fields()->create([
            'type'     => 'string',
            'name'     => 'title_8',
            'position' => 8,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_8->fields()->create([
            'type'     => 'text',
            'name'     => 'text_9',
            'position' => 9,
            'title'    => "Text",
        ]);

        $template_8->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_10',
            'position' => 10,
            'title'    => "Video",
        ]);

        $template_8->fields()->create([
            'type'     => 'string',
            'name'     => 'link_11',
            'position' => 11,
            'title'    => "Link",
        ]);






        /** @var \App\Models\Template $template_9 */
        $template_9 = \App\Models\Template::create([
            'name' => 'Template 9',
        ]);

        $template_9->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_9->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_2',
            'position' => 2,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_9->fields()->create([
            'type'     => 'string',
            'name'     => 'link_3',
            'position' => 3,
            'title'    => "Link",
        ]);

        $template_9->fields()->create([
            'type'     => 'text',
            'name'     => 'text_4',
            'position' => 4,
            'title'    => "Text",
        ]);

        $template_9->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_5',
            'position' => 5,
            'title'    => "Image",
        ]);

        $template_9->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_6',
            'position' => 6,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_9->fields()->create([
            'type'     => 'text',
            'name'     => 'text_8',
            'position' => 8,
            'title'    => "Text",
        ]);

        $template_9->fields()->create([
            'type'     => 'string',
            'name'     => 'title_9',
            'position' => 9,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_9->fields()->create([
            'type'     => 'text',
            'name'     => 'text_10',
            'position' => 10,
            'title'    => "Text",
        ]);

        $template_9->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_11',
            'position' => 11,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);








        /** @var \App\Models\Template $template_10 */
        $template_10 = \App\Models\Template::create([
            'name' => 'Template 10',
        ]);

        $template_10->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'limits'   => 100,
            'position' => 1,
            'title'    => "Title",
        ]);

        $template_10->fields()->create([
            'type'     => 'text',
            'name'     => 'text_2',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_10->fields()->create([
            'type'     => 'string',
            'name'     => 'link_3',
            'position' => 3,
            'title'    => "Link",
        ]);

        $template_10->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_4',
            'position' => 4,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_10->fields()->create([
            'type'     => 'string',
            'name'     => 'title_5',
            'limits'   => 100,
            'position' => 5,
            'title'    => "Title",
        ]);

        $template_10->fields()->create([
            'type'     => 'text',
            'name'     => 'text_6',
            'position' => 6,
            'title'    => "Text",
        ]);

        $template_10->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_7',
            'position' => 7,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_10->fields()->create([
            'type'     => 'text',
            'name'     => 'text_9',
            'position' => 9,
            'title'    => "Text",
        ]);

        $template_10->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_10',
            'position' => 10,
            'title'    => "Image",
        ]);

        $template_10->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_11',
            'position' => 11,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_10->fields()->create([
            'type'     => 'string',
            'name'     => 'title_13',
            'limits'   => 100,
            'position' => 13,
            'title'    => "Title",
        ]);

        $template_10->fields()->create([
            'type'     => 'text',
            'name'     => 'text_14',
            'position' => 14,
            'title'    => "Text",
        ]);







        /** @var \App\Models\Template $template_11 */
        $template_11 = \App\Models\Template::create([
            'name' => 'Template 11',
        ]);

        $template_11->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_11->fields()->create([
            'type'     => 'text',
            'name'     => 'text_2',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_11->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_3',
            'position' => 3,
            'title'    => "Image",
        ]);

        $template_11->fields()->create([
            'type'     => 'string',
            'name'     => 'link_4',
            'position' => 4,
            'title'    => "Link",
        ]);

        $template_11->fields()->create([
            'type'     => 'text',
            'name'     => 'text_5',
            'position' => 5,
            'limits'   => 100,
            'title'    => "Text",
        ]);

        $template_11->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_6',
            'position' => 6,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_11->fields()->create([
            'type'     => 'string',
            'name'     => 'title_7',
            'position' => 7,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_11->fields()->create([
            'type'     => 'text',
            'name'     => 'text_8',
            'position' => 8,
            'title'    => "Text",
        ]);

        $template_11->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_9',
            'position' => 9,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_11->fields()->create([
            'type'     => 'text',
            'name'     => 'text_11',
            'position' => 11,
            'title'    => "Text",
        ]);

        $template_11->fields()->create([
            'type'     => 'string',
            'name'     => 'title_12',
            'position' => 12,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_11->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_13',
            'position' => 13,
            'title'    => "Image",
        ]);

        $template_11->fields()->create([
            'type'     => 'text',
            'name'     => 'text_14',
            'position' => 14,
            'title'    => "Text",
        ]);







        /** @var \App\Models\Template $template_12 */
        $template_12 = \App\Models\Template::create([
            'name' => 'Template 12',
        ]);

        $template_12->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_12->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_2',
            'position' => 2,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_12->fields()->create([
            'type'     => 'string',
            'name'     => 'link_3',
            'position' => 3,
            'title'    => "Link",
        ]);

        $template_12->fields()->create([
            'type'     => 'text',
            'name'     => 'text_4',
            'position' => 4,
            'title'    => "Text",
        ]);

        $template_12->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_5',
            'position' => 5,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_12->fields()->create([
            'type'     => 'string',
            'name'     => 'title_7',
            'position' => 7,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_12->fields()->create([
            'type'     => 'text',
            'name'     => 'text_8',
            'position' => 8,
            'title'    => "Text",
        ]);

        $template_12->fields()->create([
            'type'     => 'string',
            'name'     => 'link_9',
            'position' => 9,
            'title'    => "Link",
        ]);

        $template_12->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_10',
            'position' => 10,
            'title'    => "Video",
        ]);

        $template_12->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_11',
            'position' => 11,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_12->fields()->create([
            'type'     => 'text',
            'name'     => 'text_13',
            'position' => 13,
            'title'    => "Text",
        ]);

        $template_12->fields()->create([
            'type'     => 'string',
            'name'     => 'title_14',
            'position' => 14,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_12->fields()->create([
            'type'     => 'text',
            'name'     => 'text_15',
            'position' => 15,
            'title'    => "Text",
        ]);

        $template_12->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_16',
            'position' => 16,
            'title'    => "Image",
        ]);








        /** @var \App\Models\Template $template_13 */
        $template_13 = \App\Models\Template::create([
            'name' => 'Template 13',
        ]);

        $template_13->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_13->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_2',
            'position' => 2,
            'title'    => "Video",
        ]);

        $template_13->fields()->create([
            'type'     => 'string',
            'name'     => 'link_3',
            'position' => 3,
            'title'    => "Link",
        ]);

        $template_13->fields()->create([
            'type'     => 'text',
            'name'     => 'text_4',
            'position' => 4,
            'title'    => "Text",
        ]);

        $template_13->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_5',
            'position' => 5,
            'title'    => "Image",
        ]);

        $template_13->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_7',
            'position' => 7,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_13->fields()->create([
            'type'     => 'string',
            'name'     => 'title_8',
            'position' => 8,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_13->fields()->create([
            'type'     => 'text',
            'name'     => 'text_9',
            'position' => 9,
            'title'    => "Text",
        ]);

        $template_13->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_10',
            'position' => 10,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_13->fields()->create([
            'type'     => 'text',
            'name'     => 'text_12',
            'position' => 12,
            'title'    => "Text",
        ]);

        $template_13->fields()->create([
            'type'     => 'string',
            'name'     => 'link_13',
            'position' => 13,
            'title'    => "Link",
        ]);

        $template_13->fields()->create([
            'type'     => 'string',
            'name'     => 'title_14',
            'position' => 14,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_13->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_15',
            'position' => 15,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_13->fields()->create([
            'type'     => 'text',
            'name'     => 'text_16',
            'position' => 16,
            'title'    => "Text",
        ]);






        /** @var \App\Models\Template $template_14 */
        $template_14 = \App\Models\Template::create([
            'name' => 'Template 14',
        ]);

        $template_14->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_14->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_2',
            'position' => 2,
            'title'    => "Image",
        ]);

        $template_14->fields()->create([
            'type'     => 'text',
            'name'     => 'text_3',
            'position' => 3,
            'title'    => "Text",
        ]);

        $template_14->fields()->create([
            'type'     => 'string',
            'name'     => 'title_4',
            'position' => 4,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_14->fields()->create([
            'type'     => 'text',
            'name'     => 'text_5',
            'position' => 5,
            'title'    => "Text",
        ]);

        $template_14->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_6',
            'position' => 6,
            'title'    => "Video",
        ]);

        $template_14->fields()->create([
            'type'     => 'string',
            'name'     => 'link_7',
            'position' => 7,
            'title'    => "Link",
        ]);

        $template_14->fields()->create([
            'type'     => 'string',
            'name'     => 'title_8',
            'position' => 8,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_14->fields()->create([
            'type'     => 'text',
            'name'     => 'text_9',
            'position' => 9,
            'title'    => "Text",
        ]);

        $template_14->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_10',
            'position' => 10,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_14->fields()->create([
            'type'     => 'text',
            'name'     => 'text_12',
            'position' => 12,
            'title'    => "Text",
        ]);

        $template_14->fields()->create([
            'type'     => 'string',
            'name'     => 'link_13',
            'position' => 13,
            'title'    => "Link",
        ]);








        /** @var \App\Models\Template $template_15 */
        $template_15 = \App\Models\Template::create([
            'name' => 'Template 15',
        ]);

        $template_15->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_1',
            'position' => 1,
            'title'    => "Image",
        ]);

        $template_15->fields()->create([
            'type'     => 'string',
            'name'     => 'title_2',
            'position' => 2,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_15->fields()->create([
            'type'     => 'text',
            'name'     => 'text_3',
            'position' => 3,
            'title'    => "Text",
        ]);

        $template_15->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_4',
            'position' => 4,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_15->fields()->create([
            'type'     => 'text',
            'name'     => 'text_5',
            'position' => 5,
            'title'    => "Text",
        ]);

        $template_15->fields()->create([
            'type'     => 'string',
            'name'     => 'title_6',
            'position' => 6,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_15->fields()->create([
            'type'     => 'text',
            'name'     => 'text_7',
            'position' => 7,
            'title'    => "Text",
        ]);

        $template_15->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_8',
            'position' => 8,
            'title'    => "Video",
        ]);

        $template_15->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_9',
            'position' => 9,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_15->fields()->create([
            'type'     => 'string',
            'name'     => 'link_11',
            'position' => 11,
            'title'    => "Link",
        ]);


        $template_15->fields()->create([
            'type'     => 'text',
            'name'     => 'text_12',
            'position' => 12,
            'title'    => "Text",
        ]);

        $template_15->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_13',
            'position' => 13,
            'title'    => "Image",
        ]);

        $template_15->fields()->create([
            'type'     => 'text',
            'name'     => 'text_14',
            'position' => 14,
            'title'    => "Text",
        ]);







        /** @var \App\Models\Template $template_16 */
        $template_16 = \App\Models\Template::create([
            'name' => 'Template 16',
        ]);

        $template_16->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_1',
            'position' => 1,
            'title'    => "Video",
        ]);

        $template_16->fields()->create([
            'type'     => 'string',
            'name'     => 'link_2',
            'position' => 2,
            'title'    => "Link",
        ]);

        $template_16->fields()->create([
            'type'     => 'string',
            'name'     => 'title_3',
            'position' => 3,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_16->fields()->create([
            'type'     => 'text',
            'name'     => 'text_4',
            'position' => 4,
            'title'    => "Text",
        ]);

        $template_16->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_5',
            'position' => 5,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_16->fields()->create([
            'type'     => 'text',
            'name'     => 'text_7',
            'position' => 7,
            'title'    => "Text",
        ]);

        $template_16->fields()->create([
            'type'     => 'string',
            'name'     => 'title_8',
            'position' => 8,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_16->fields()->create([
            'type'     => 'text',
            'name'     => 'text_9',
            'position' => 9,
            'title'    => "Text",
        ]);

        $template_16->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_10',
            'position' => 10,
            'title'    => "Image",
        ]);

        $template_16->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_11',
            'position' => 11,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_16->fields()->create([
            'type'     => 'string',
            'name'     => 'link_13',
            'position' => 13,
            'title'    => "Link",
        ]);







        /** @var \App\Models\Template $template_17 */
        $template_17 = \App\Models\Template::create([
            'name' => 'Template 17',
        ]);

        $template_17->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_1',
            'position' => 1,
            'title'    => "Image",
        ]);

        $template_17->fields()->create([
            'type'     => 'string',
            'name'     => 'link_2',
            'position' => 2,
            'title'    => "Link",
        ]);

        $template_17->fields()->create([
            'type'     => 'string',
            'name'     => 'title_3',
            'position' => 3,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_17->fields()->create([
            'type'     => 'text',
            'name'     => 'text_4',
            'position' => 4,
            'title'    => "Text",
        ]);

        $template_17->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_5',
            'position' => 5,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_17->fields()->create([
            'type'     => 'string',
            'name'     => 'title_7',
            'position' => 7,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_17->fields()->create([
            'type'     => 'text',
            'name'     => 'text_8',
            'position' => 8,
            'title'    => "Text",
        ]);

        $template_17->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_9',
            'position' => 9,
            'title'    => "Video",
        ]);

        $template_17->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_10',
            'position' => 10,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_17->fields()->create([
            'type'     => 'string',
            'name'     => 'link_12',
            'position' => 12,
            'title'    => "Link",
        ]);

        $template_17->fields()->create([
            'type'     => 'text',
            'name'     => 'text_13',
            'position' => 13,
            'title'    => "Text",
        ]);

        $template_17->fields()->create([
            'type'     => 'string',
            'name'     => 'title_14',
            'position' => 14,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_17->fields()->create([
            'type'     => 'text',
            'name'     => 'text_15',
            'position' => 15,
            'title'    => "Text",
        ]);








        /** @var \App\Models\Template $template_18 */
        $template_18 = \App\Models\Template::create([
            'name' => 'Template 18',
        ]);

        $template_18->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_18->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_2',
            'position' => 2,
            'title'    => "Image",
        ]);

        $template_18->fields()->create([
            'type'     => 'text',
            'name'     => 'text_3',
            'position' => 3,
            'title'    => "Text",
        ]);

        $template_18->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_4',
            'position' => 4,
            'title'    => "Video",
        ]);

        $template_18->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_5',
            'position' => 5,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_18->fields()->create([
            'type'     => 'string',
            'name'     => 'link_7',
            'position' => 7,
            'title'    => "Link",
        ]);

        $template_18->fields()->create([
            'type'     => 'text',
            'name'     => 'text_8',
            'position' => 8,
            'title'    => "Text",
        ]);

        $template_18->fields()->create([
            'type'     => 'string',
            'name'     => 'title_9',
            'position' => 9,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_18->fields()->create([
            'type'     => 'text',
            'name'     => 'text_10',
            'position' => 10,
            'title'    => "Text",
        ]);

        $template_18->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_11',
            'position' => 11,
            'title'    => "Image",
        ]);

        $template_18->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_12',
            'position' => 12,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_18->fields()->create([
            'type'     => 'string',
            'name'     => 'link_14',
            'position' => 14,
            'title'    => "Link",
        ]);





        /** @var \App\Models\Template $template_19 */
        $template_19 = \App\Models\Template::create([
            'name' => 'Template 19',
        ]);

        $template_19->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_1',
            'position' => 1,
            'title'    => "Video",
        ]);

        $template_19->fields()->create([
            'type'     => 'string',
            'name'     => 'title_2',
            'position' => 2,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_19->fields()->create([
            'type'     => 'text',
            'name'     => 'text_3',
            'position' => 3,
            'title'    => "Text",
        ]);

        $template_19->fields()->create([
            'type'     => 'string',
            'name'     => 'link_4',
            'position' => 4,
            'title'    => "Link",
        ]);

        $template_19->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_5',
            'position' => 5,
            'title'    => "Image",
        ]);

        $template_19->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_6',
            'position' => 6,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_19->fields()->create([
            'type'     => 'string',
            'name'     => 'title_8',
            'limits'   => 100,
            'position' => 8,
            'title'    => "Title",
        ]);

        $template_19->fields()->create([
            'type'     => 'text',
            'name'     => 'text_9',
            'position' => 9,
            'title'    => "Text",
        ]);

        $template_19->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_8',
            'position' => 8,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_19->fields()->create([
            'type'     => 'text',
            'name'     => 'text_12',
            'position' => 12,
            'title'    => "Text",
        ]);

        $template_19->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_13',
            'position' => 13,
            'title'    => "Image",
        ]);





        /** @var \App\Models\Template $template_20 */
        $template_20 = \App\Models\Template::create([
            'name' => 'Template 20',
        ]);

        $template_20->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'limits'   => 100,
            'position' => 1,
            'title'    => "Title",
        ]);

        $template_20->fields()->create([
            'type'     => 'text',
            'name'     => 'text_2',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_20->fields()->create([
            'type'     => 'string',
            'name'     => 'title_3',
            'limits'   => 100,
            'position' => 3,
            'title'    => "Title",
        ]);

        $template_20->fields()->create([
            'type'     => 'text',
            'name'     => 'text_4',
            'position' => 4,
            'title'    => "Text",
        ]);

        $template_20->fields()->create([
            'type'     => 'string',
            'name'     => 'link_5',
            'position' => 5,
            'title'    => "Link",
        ]);

        $template_20->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_6',
            'position' => 6,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_20->fields()->create([
            'type'     => 'string',
            'name'     => 'title_7',
            'position' => 7,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_20->fields()->create([
            'type'     => 'text',
            'name'     => 'text_8',
            'position' => 8,
            'title'    => "Text",
        ]);

        $template_20->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_9',
            'position' => 9,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_20->fields()->create([
            'type'     => 'text',
            'name'     => 'text_11',
            'position' => 11,
            'title'    => "Text",
        ]);

        $template_20->fields()->create([
            'type'     => 'string',
            'name'     => 'link_12',
            'position' => 12,
            'title'    => "Link",
        ]);






        /** @var \App\Models\Template $template_21 */
        $template_21 = \App\Models\Template::create([
            'name' => 'Template 21',
        ]);

        $template_21->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_21->fields()->create([
            'type'     => 'text',
            'name'     => 'text_2',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_21->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_3',
            'position' => 3,
            'title'    => "Video",
        ]);

        $template_21->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_4',
            'position' => 4,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_21->fields()->create([
            'type'     => 'string',
            'name'     => 'link_6',
            'position' => 6,
            'title'    => "Link",

        ]);

        $template_21->fields()->create([
            'type'     => 'text',
            'name'     => 'text_7',
            'position' => 7,
            'title'    => "Text",
        ]);

        $template_21->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_8',
            'position' => 8,
            'title'    => "Image",
        ]);

        $template_21->fields()->create([
            'type'     => 'string',
            'name'     => 'title_9',
            'position' => 9,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_21->fields()->create([
            'type'     => 'text',
            'name'     => 'text_10',
            'position' => 10,
            'title'    => "Text",
        ]);

        $template_21->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_11',
            'position' => 11,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_21->fields()->create([
            'type'     => 'text',
            'name'     => 'text_13',
            'position' => 13,
            'title'    => "Text",
        ]);

        $template_21->fields()->create([
            'type'     => 'string',
            'name'     => 'link_14',
            'position' => 14,
            'title'    => "Link",
        ]);








        /** @var \App\Models\Template $template_22 */
        $template_22 = \App\Models\Template::create([
            'name' => 'Template 22',
        ]);

        $template_22->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_22->fields()->create([
            'type'     => 'text',
            'name'     => 'text_2',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_22->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_3',
            'position' => 3,
            'title'    => "Video",
        ]);

        $template_22->fields()->create([
            'type'     => 'string',
            'name'     => 'link_4',
            'position' => 4,
            'title'    => "Link",
        ]);

        $template_22->fields()->create([
            'type'     => 'text',
            'name'     => 'text_5',
            'position' => 5,
            'title'    => "Text",
        ]);

        $template_22->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_6',
            'position' => 6,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_22->fields()->create([
            'type'     => 'string',
            'name'     => 'title_7',
            'position' => 7,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_22->fields()->create([
            'type'     => 'text',
            'name'     => 'text_8',
            'position' => 8,
            'title'    => "Text",
        ]);

        $template_22->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_9',
            'position' => 9,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_22->fields()->create([
            'type'     => 'string',
            'name'     => 'link_11',
            'position' => 11,
            'title'    => "Link",
        ]);

        $template_22->fields()->create([
            'type'     => 'text',
            'name'     => 'text_12',
            'position' => 12,
            'title'    => "Text",
        ]);







        /** @var \App\Models\Template $template_23 */
        $template_23 = \App\Models\Template::create([
            'name' => 'Template 23',
        ]);

        $template_23->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Video",
        ]);

        $template_23->fields()->create([
            'type'     => 'string',
            'name'     => 'title_2',
            'position' => 2,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_23->fields()->create([
            'type'     => 'text',
            'name'     => 'text_3',
            'position' => 3,
            'title'    => "Text",
        ]);

        $template_23->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_4',
            'position' => 4,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_23->fields()->create([
            'type'     => 'text',
            'name'     => 'text_5',
            'position' => 5,
            'title'    => "Text",
        ]);

        $template_23->fields()->create([
            'type'     => 'string',
            'name'     => 'title_6',
            'position' => 6,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_23->fields()->create([
            'type'     => 'text',
            'name'     => 'text_7',
            'position' => 7,
            'title'    => "Text",
        ]);

        $template_23->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_8',
            'position' => 8,
            'title'    => "Image",
        ]);

        $template_23->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_9',
            'position' => 9,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_23->fields()->create([
            'type'     => 'text',
            'name'     => 'text_11',
            'position' => 11,
            'title'    => "Text",
        ]);

        $template_23->fields()->create([
            'type'     => 'string',
            'name'     => 'link_12',
            'position' => 12,
            'title'    => "Link",
        ]);




        /** @var \App\Models\Template $template_24 */
        $template_24 = \App\Models\Template::create([
            'name' => 'Template 24',
        ]);

        $template_24->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'limits'   => 100,
            'position' => 1,
            'title'    => "Title",
        ]);

        $template_24->fields()->create([
            'type'     => 'text',
            'name'     => 'text_2',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_24->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_3',
            'position' => 3,
            'title'    => "Image",
        ]);

        $template_24->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_4',
            'position' => 4,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_24->fields()->create([
            'type'     => 'text',
            'name'     => 'text_6',
            'position' => 6,
            'title'    => "Text",
        ]);

        $template_24->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_7',
            'position' => 7,
            'title'    => "Video",
        ]);

        $template_24->fields()->create([
            'type'     => 'string',
            'name'     => 'link_8',
            'position' => 8,
            'title'    => "Link",
        ]);

        $template_24->fields()->create([
            'type'     => 'text',
            'name'     => 'text_9',
            'position' => 9,
            'title'    => "Text",
        ]);

        $template_24->fields()->create([
            'type'     => 'string',
            'name'     => 'title_10',
            'position' => 10,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_24->fields()->create([
            'type'     => 'text',
            'name'     => 'text_11',
            'position' => 11,
            'title'    => "Text",
        ]);

        $template_24->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_12',
            'position' => 12,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_24->fields()->create([
            'type'     => 'text',
            'name'     => 'text_14',
            'position' => 14,
            'title'    => "Text",
        ]);






        /** @var \App\Models\Template $template_25 */
        $template_25 = \App\Models\Template::create([
            'name' => 'Template 25',
        ]);

        $template_25->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_1',
            'position' => 1,
            'title'    => "Image",
        ]);

        $template_25->fields()->create([
            'type'     => 'text',
            'name'     => 'text_2',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_25->fields()->create([
            'type'     => 'string',
            'name'     => 'link_3',
            'position' => 3,
            'title'    => "Link",
        ]);

        $template_25->fields()->create([
            'type'     => 'string',
            'name'     => 'title_4',
            'position' => 4,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_25->fields()->create([
            'type'     => 'text',
            'name'     => 'text_5',
            'position' => 5,
            'title'    => "Text",
        ]);

        $template_25->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_6',
            'position' => 6,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_25->fields()->create([
            'type'     => 'string',
            'name'     => 'title_7',
            'position' => 7,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_25->fields()->create([
            'type'     => 'text',
            'name'     => 'text_8',
            'position' => 8,
            'title'    => "Text",
        ]);

        $template_25->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_9',
            'position' => 9,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_25->fields()->create([
            'type'     => 'string',
            'name'     => 'link_11',
            'position' => 11,
            'title'    => "Link",
        ]);

        $template_25->fields()->create([
            'type'     => 'text',
            'name'     => 'text_12',
            'position' => 12,
            'title'    => "Text",
        ]);






        /** @var \App\Models\Template $template_26 */
        $template_26 = \App\Models\Template::create([
            'name' => 'Template 26',
        ]);

        $template_26->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_26->fields()->create([
            'type'     => 'text',
            'name'     => 'text_2',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_26->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_3',
            'position' => 3,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_26->fields()->create([
            'type'     => 'text',
            'name'     => 'text_4',
            'position' => 4,
            'title'    => "Text",
        ]);

        $template_26->fields()->create([
            'type'     => 'string',
            'name'     => 'title_5',
            'position' => 5,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_26->fields()->create([
            'type'     => 'text',
            'name'     => 'text_6',
            'position' => 6,
            'title'    => "Text",
        ]);

        $template_26->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_7',
            'position' => 7,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_26->fields()->create([
            'type'     => 'text',
            'name'     => 'text_9',
            'position' => 9,
            'title'    => "Text",
        ]);

        $template_26->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_10',
            'position' => 10,
            'title'    => "Image",
        ]);

        $template_26->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_11',
            'position' => 11,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_26->fields()->create([
            'type'     => 'string',
            'name'     => 'link_13',
            'position' => 13,
            'title'    => "Link",
        ]);





        /** @var \App\Models\Template $template_27 */
        $template_27 = \App\Models\Template::create([
            'name' => 'Template 27',
        ]);

        $template_27->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_27->fields()->create([
            'type'     => 'text',
            'name'     => 'text_2',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_27->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_3',
            'position' => 3,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_27->fields()->create([
            'type'     => 'text',
            'name'     => 'text_5',
            'position' => 5,
            'title'    => "Text",
        ]);

        $template_27->fields()->create([
            'type'     => 'string',
            'name'     => 'link_6',
            'position' => 6,
            'title'    => "Link",
        ]);

        $template_27->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_7',
            'position' => 7,
            'title'    => "Image",
        ]);

        $template_27->fields()->create([
            'type'     => 'string',
            'name'     => 'title_8',
            'position' => 8,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_27->fields()->create([
            'type'     => 'text',
            'name'     => 'text_9',
            'position' => 9,
            'title'    => "Text",
        ]);

        $template_27->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_10',
            'position' => 10,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_27->fields()->create([
            'type'     => 'text',
            'name'     => 'text_12',
            'position' => 12,
            'title'    => "Text",
        ]);





        /** @var \App\Models\Template $template_28 */
        $template_28 = \App\Models\Template::create([
            'name' => 'Template 28',
        ]);

        $template_28->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_28->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_2',
            'position' => 2,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_28->fields()->create([
            'type'     => 'text',
            'name'     => 'text_4',
            'position' => 4,
            'title'    => "Text",
        ]);

        $template_28->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_5',
            'position' => 5,
            'title'    => "Image",
        ]);

        $template_28->fields()->create([
            'type'     => 'string',
            'name'     => 'link_6',
            'position' => 6,
            'title'    => "Link",
        ]);

        $template_28->fields()->create([
            'type'     => 'string',
            'name'     => 'title_7',
            'position' => 7,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_28->fields()->create([
            'type'     => 'text',
            'name'     => 'text_8',
            'position' => 8,
            'title'    => "Text",
        ]);

        $template_28->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_9',
            'position' => 9,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_28->fields()->create([
            'type'     => 'text',
            'name'     => 'text_10',
            'position' => 10,
            'title'    => "Text",
        ]);

        $template_28->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_11',
            'position' => 11,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);




        /** @var \App\Models\Template $template_29 */
        $template_29 = \App\Models\Template::create([
            'name' => 'Template 29',
        ]);

        $template_29->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_29->fields()->create([
            'type'     => 'text',
            'name'     => 'text_2',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_29->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_3',
            'position' => 3,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_29->fields()->create([
            'type'     => 'string',
            'name'     => 'title_5',
            'position' => 5,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_29->fields()->create([
            'type'     => 'text',
            'name'     => 'text_6',
            'position' => 6,
            'title'    => "Text",
        ]);

        $template_29->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_7',
            'position' => 7,
            'title'    => "Image",
        ]);

        $template_29->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_8',
            'position' => 8,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_29->fields()->create([
            'type'     => 'string',
            'name'     => 'title_10',
            'position' => 10,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_29->fields()->create([
            'type'     => 'text',
            'name'     => 'text_11',
            'position' => 11,
            'title'    => "Text",
        ]);

        $template_29->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_12',
            'position' => 12,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_29->fields()->create([
            'type'     => 'text',
            'name'     => 'text_13',
            'position' => 13,
            'title'    => "Text",
        ]);










        /** @var \App\Models\Template $template_30 */
        $template_30 = \App\Models\Template::create([
            'name' => 'Template 30',
        ]);

        $template_30->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_30->fields()->create([
            'type'     => 'text',
            'name'     => 'text_2',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_30->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_3',
            'position' => 3,
            'title'    => "Image",
        ]);

        $template_30->fields()->create([
            'type'     => 'text',
            'name'     => 'text_4',
            'position' => 4,
            'title'    => "Text",
        ]);

        $template_30->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_5',
            'position' => 5,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_30->fields()->create([
            'type'     => 'string',
            'name'     => 'title_7',
            'position' => 7,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_30->fields()->create([
            'type'     => 'text',
            'name'     => 'text_8',
            'position' => 8,
            'title'    => "Text",
        ]);

        $template_30->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_9',
            'position' => 9,
            'title'    => "Video",
        ]);

        $template_30->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_10',
            'position' => 10,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_30->fields()->create([
            'type'     => 'string',
            'name'     => 'link_12',
            'position' => 12,
            'title'    => "Link",
        ]);

        $template_30->fields()->create([
            'type'     => 'text',
            'name'     => 'text_13',
            'position' => 13,
            'title'    => "Text",
        ]);

        $template_30->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_14',
            'position' => 14,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        /** @var \App\Models\Template $template_32 */
        $template_32 = \App\Models\Template::create([
            'name' => 'Template 32',
        ]);

        $template_32->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_32->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_2',
            'position' => 2,
            'title'    => "Photo",
        ]);

        $template_32->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_3',
            'position' => 3,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_32->fields()->create([
            'type'     => 'string',
            'name'     => 'title_4',
            'position' => 4,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_32->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_5',
            'position' => 5,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_32->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_6',
            'position' => 6,
            'title'    => "Video",
        ]);

        $template_32->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_7',
            'position' => 7,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        /** @var \App\Models\Template $template_33 */
        $template_33 = \App\Models\Template::create([
            'name' => 'Template 33',
        ]);

        $template_33->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_1',
            'position' => 1,
            'title'    => "Photo",
        ]);

        $template_33->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_2',
            'position' => 2,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_33->fields()->create([
            'type'     => 'string',
            'name'     => 'title_3',
            'position' => 3,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_33->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_4',
            'position' => 4,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_33->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_5',
            'position' => 5,
            'title'    => "Video",
        ]);

        $template_33->fields()->create([
            'type'     => 'string',
            'name'     => 'title_6',
            'position' => 6,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_33->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_7',
            'position' => 7,
            'title'    => "Photo",
        ]);

        $template_33->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_8',
            'position' => 8,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        /** @var \App\Models\Template $template_34 */
        $template_34 = \App\Models\Template::create([
            'name' => 'Template 34',
        ]);

        $template_34->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_1',
            'position' => 1,
            'title'    => "Video",
        ]);

        $template_34->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_2',
            'position' => 2,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_34->fields()->create([
            'type'     => 'string',
            'name'     => 'title_3',
            'position' => 3,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_34->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_4',
            'position' => 4,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_34->fields()->create([
            'type'     => 'string',
            'name'     => 'title_5',
            'position' => 5,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_34->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_6',
            'position' => 6,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_34->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_7',
            'position' => 7,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        /** @var \App\Models\Template $template_35 */
        $template_35 = \App\Models\Template::create([
            'name' => 'Template 35',
        ]);

        $template_35->fields()->create([
            'type'     => 'string',
            'name'     => 'title_1',
            'position' => 1,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_35->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_2',
            'position' => 2,
            'title'    => "Video",
        ]);

        $template_35->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_3',
            'position' => 3,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_35->fields()->create([
            'type'     => 'string',
            'name'     => 'title_4',
            'position' => 4,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_35->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_5',
            'position' => 5,
            'title'    => "Photo",
        ]);

        $template_35->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_6',
            'position' => 6,
            'limits'   => 100,
            'title'    => "Two Videos",
        ]);

        $template_35->fields()->create([
            'type'     => 'string',
            'name'     => 'title_7',
            'position' => 7,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_35->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_8',
            'position' => 8,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        /** @var \App\Models\Template $template_36 */
        $template_36 = \App\Models\Template::create([
            'name' => 'Template 36',
        ]);

        $template_36->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_1',
            'position' => 1,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_36->fields()->create([
            'type'     => 'string',
            'name'     => 'title_2',
            'position' => 2,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_36->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_3',
            'position' => 3,
            'title'    => "Photo",
        ]);

        $template_36->fields()->create([
            'type'     => 'string',
            'name'     => 'title_4',
            'position' => 4,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_36->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_5',
            'position' => 5,
            'title'    => "Video",
        ]);

        $template_36->fields()->create([
            'type'     => 'two_images',
            'name'     => 'two_images_6',
            'position' => 6,
            'limits'   => 100,
            'title'    => "Two Images",
        ]);

        $template_36->fields()->create([
            'type'     => 'string',
            'name'     => 'title_7',
            'position' => 7,
            'limits'   => 100,
            'title'    => "Title",
        ]);

        $template_36->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_8',
            'position' => 8,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);

        $template_36->fields()->create([
            'type'     => 'gallery',
            'name'     => 'gallery_9',
            'position' => 9,
            'limits'   => 10,
            'title'    => "Gallery",
        ]);
    }
}

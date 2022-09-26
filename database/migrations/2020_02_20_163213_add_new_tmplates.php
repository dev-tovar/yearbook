<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;

class AddNewTmplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('templates')->where('category_name','like','Student Tribute%')->delete();

        /****** Basic ********/

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
            'type'     => 'image',
            'name'     => 'user_image_1',
            'position' => 1,
            'title'    => "Image",
        ]);

        $template_basic_1->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_2',
            'position' => 2,
            'title'    => "Video",
        ]);
        $template_basic_1->fields()->create([
            'type'     => 'text',
            'name'     => 'text_1',
            'position' => 3,
            'title'    => "Text",
        ]);

        $template_basic_1->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_3',
            'position' => 4,
            'title'    => "Image",
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
            'title'    => "Image",
        ]);

        $template_basic_2->fields()->create([
            'type'     => 'text',
            'name'     => 'text_1',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_basic_2->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_2',
            'position' => 3,
            'title'    => "Video",
        ]);


        $template_basic_2->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_3',
            'position' => 4,
            'title'    => "Image",
        ]);



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
            'type'     => 'image',
            'name'     => 'user_image_2',
            'position' => 1,
            'title'    => "Video",
        ]);

        $template_basic_3->fields()->create([
            'type'     => 'text',
            'name'     => 'text_1',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_basic_3->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_1',
            'position' => 3,
            'title'    => "Image",
        ]);

        $template_basic_3->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_3',
            'position' => 4,
            'title'    => "Image",
        ]);

        /****** PREMIUM ********/

        /** @var \App\Models\Template $template_premium_1 */
        $template_premium_1 = \App\Models\Template::create([
            'name'          => 'Template 4',
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
            'title'    => "Video",
        ]);

        $template_premium_1->fields()->create([
            'type'     => 'text',
            'name'     => 'text_1',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_premium_1->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_2',
            'position' => 3,
            'title'    => "Image",
        ]);

        $template_premium_1->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_3',
            'position' => 4,
            'title'    => "Video",
        ]);

        $template_premium_1->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_4',
            'position' => 5,
            'title'    => "Image",
        ]);

        $template_premium_1->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_5',
            'position' => 6,
            'title'    => "Image",
        ]);

        $template_premium_1->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_6',
            'position' => 7,
            'title'    => "Image",
        ]);

        /********/

        /** @var \App\Models\Template $template_premium_2 */
        $template_premium_2 = \App\Models\Template::create([
            'name'          => 'Template 5',
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
            'type'     => 'image',
            'name'     => 'user_image_2',
            'position' => 1,
            'title'    => "Image",
        ]);

        $template_premium_2->fields()->create([
            'type'     => 'text',
            'name'     => 'text_1',
            'position' => 2,
            'title'    => "Text",
        ]);

        $template_premium_2->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_1',
            'position' => 3,
            'title'    => "Video",
        ]);

        $template_premium_2->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_4',
            'position' => 4,
            'title'    => "Image",
        ]);

        $template_premium_2->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_3',
            'position' => 5,
            'title'    => "Video",
        ]);

        $template_premium_2->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_5',
            'position' => 6,
            'title'    => "Image",
        ]);

        $template_premium_2->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_6',
            'position' => 7,
            'title'    => "Image",
        ]);


        /********/

        /** @var \App\Models\Template $template_premium_3 */
        $template_premium_3 = \App\Models\Template::create([
            'name'          => 'Template 6',
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
            'type'     => 'image',
            'name'     => 'user_image_2',
            'position' => 1,
            'title'    => "Image",
        ]);

        $template_premium_3->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_1',
            'position' => 2,
            'title'    => "Video",
        ]);

        $template_premium_3->fields()->create([
            'type'     => 'text',
            'name'     => 'text_1',
            'position' => 3,
            'title'    => "Text",
        ]);

        $template_premium_3->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_4',
            'position' => 4,
            'title'    => "Image",
        ]);

        $template_premium_3->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_3',
            'position' => 5,
            'title'    => "Video",
        ]);

        $template_premium_3->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_5',
            'position' => 6,
            'title'    => "Image",
        ]);

        $template_premium_3->fields()->create([
            'type'     => 'image',
            'name'     => 'user_image_6',
            'position' => 7,
            'title'    => "Image",
        ]);

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

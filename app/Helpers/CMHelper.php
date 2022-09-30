<?php
/**
 * Created by PhpStorm.
 * User: tabbakka
 * Date: 7/30/18
 * Time: 11:59 AM
 */

namespace App\Helpers;


use App\Models\ContentCategory;

class CMHelper
{
    protected $categories;
    protected $cover;
    protected $schoolSpirit;
    protected $sports;
    protected $clubs;
    protected $studentTribute;
    protected $grades;
    protected $studentsProfile;
    protected $defaultCategories;

    private $gragesList;

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        return null;
    }

    public function __construct($data)
    {
        $this->gragesList      = [
            'PK-5'  => ['PK', 'K', '1', '2', '3', '4', '5'],
            'PK-8'  => ['PK', 'K', '1', '2', '3', '4', '5', '6', '7', '8'],
            'PK-12' => [
                'PK',
                'K',
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                '10',
                '11',
                '12',
            ],
            '6-8'   => ['6', '7', '8'],
            '6-12'  => ['6', '7', '8', '9', '10', '11', '12'],
            '9-12'  => ['9', '10', '11', '12'],
        ];
        $this->cover           = $this->cover($data);
        $this->schoolSpirit    = $this->schoolSpirit($data);
        $this->sports          = $this->sports($data);
        $this->clubs           = $this->clubs($data);
        $this->studentTribute  = $this->studentTribute($data);
        $this->grades          = $this->grades($data);
        $this->studentsProfile = $this->studentsProfile($data);

        $this->categories = [
            $this->cover,
            $this->schoolSpirit,
            $this->sports,
            $this->clubs,
            $this->studentTribute,
            $this->grades,
            $this->studentsProfile,
        ];
    }

    public function cover($data)
    {
        return ContentCategory::create([
            'name'         => 'Cover',
            'year_book_id' => $data->id,
            'can_edit'     => false,
            'position'     => 0,
        ]);
    }

    public function schoolSpirit($data)
    {
        return ContentCategory::create([
            'name'         => 'School Spirit',
            'year_book_id' => $data->id,
            'can_edit'     => true,
            'position'     => 1,
        ]);
    }

    public function sports($data)
    {
        return ContentCategory::create([
            'name'         => 'Sports',
            'year_book_id' => $data->id,
            'can_edit'     => true,
            'position'     => 2,
        ]);
    }

    public function clubs($data)
    {
        return ContentCategory::create([
            'name'         => 'Clubs',
            'year_book_id' => $data->id,
            'can_edit'     => true,
            'position'     => 3,
        ]);
    }

    public function studentTribute($data)
    {
        /** @var ContentCategory $st */
        $st = ContentCategory::create([
            'name'         => 'Student Tribute',
            'year_book_id' => $data->id,
            'can_edit'     => false,
            'position'     => 4,
        ]);

        $st->subCategories()->create([
            'name'         => 'Basic',
            'year_book_id' => $data->id,
            'can_edit'     => false,
        ]);

        $st->subCategories()->create([
            'name'         => 'Premium',
            'year_book_id' => $data->id,
            'can_edit'     => false,
        ]);

        return $st;
    }

    public function grades($data)
    {
        /** @var ContentCategory $grade */
        $grade = ContentCategory::create([
            'name'         => 'Grades',
            'year_book_id' => $data->id,
            'can_edit'     => false,
            'position'     => 5,
        ]);

        foreach ($this->gragesList[$data->school->grade] as $gr) {
            $grade->subCategories()->create([
                'name'         => $gr,
                'year_book_id' => $data->id,
                'can_edit'     => true,
            ]);
        }

        return $grade;
    }

    public function studentsProfile($data)
    {
        /** @var ContentCategory $sp */
        $sp = ContentCategory::create([
            'name'         => 'Students Profile',
            'year_book_id' => $data->id,
            'can_edit'     => false,
            'position'     => 6,
        ]);

        foreach ($this->gragesList[$data->school->grade] as $gr) {
            $sp->subCategories()->create([
                'name'         => $gr,
                'year_book_id' => $data->id,
                'can_edit'     => false,
            ]);
        }

        return $sp;
    }

    public function defaultCategories()
    {
        return $this->categories;
    }
}

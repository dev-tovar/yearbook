<?php


namespace App\Services\Admin;


use App\Repositories\YearBookRepository;
use Illuminate\Http\Request;

class UserService
{
    public const GRADES = [
        'Pre-Kindergarten',
        'Kindergarten',
        1,
        2,
        3,
        4,
        5,
        6,
        7,
        8,
        9,
        10,
        11,
        12
    ];
    protected $yearbookRepository;

    public function __construct(YearBookRepository $yearbookRepository)
    {
        $this->yearbookRepository = $yearbookRepository;
    }

    public function moveUser(Request $request)
    {
        $currentYearbookId = $request->current_yearbook_id;
        $newYearbookId = $request->next_yearbook_id;
        if (!$newYearbookId) {
            $newYearbookId = $this->yearbookRepository->getNextYearbook($currentYearbookId)->id;
        }
        $userIds = $request->user_ids;
        if (!$userIds) {
            $userIds = $this->yearbookRepository->getUserIds($currentYearbookId);
        }
        foreach ($userIds as $userId) {
            if (!$this->yearbookRepository->hasYearbook($newYearbookId, $userId)) {
                $currentGrade = $this->yearbookRepository->getGradeLvl($currentYearbookId, $userId);
                $newGrade = $this->incrementGrade($currentGrade);
                if ($newGrade) {
                    $data = [
                        'status' => 'not_paid',
                        'yearbook_id' => $newYearbookId,
                        'user_id' => $userId,
                        'grade_level' => $newGrade
                    ];
                    $this->yearbookRepository->addUserYearbook($data);
                }
            }
        }

        return true;
    }

    public function incrementGrade($currentGrade)
    {
        $i = array_search($currentGrade, self::GRADES);
        $i++;
        if (isset(self::GRADES[$i])) {
            return self::GRADES[$i];
        } else {
            return false;
        }
    }
}
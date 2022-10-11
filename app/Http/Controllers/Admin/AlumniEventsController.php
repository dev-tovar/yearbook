<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AlumniPushType;
use App\Enums\EventsVisitStatus;
use App\Feed;
use App\FeedAttachment;
use App\Http\Requests\AlumniEventCreateRequest;
use App\Models\AlumniEvent;
use App\Models\EventAttachment;
use App\Models\EventVisit;
use App\School;
use App\User;
use App\YearBook;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AlumniEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            $school = School::findOrFail($request->id);
            if (policy(User::class)->get(Auth::user(), $school)) {
                $feeds = AlumniEvent::whereSchoolId($school->id)
                    ->withCount([
                        'users AS attempt'     => function ($q) {
                            $q->where('status', EventsVisitStatus::CONFIRMED);
                        },
                        'users AS not_attempt' => function ($q) {
                            $q->where('status', EventsVisitStatus::UNCONFIRMED);
                        },
                    ])
                    ->filter($request->except('_token'))
                    ->paginate(50);

                return view('admin.events.index', [
                    'school'  => $school,
                    'feeds'   => $feeds,
                    'request' => $request,
                    'grades'  => Auth::user()->getSchool()->getAlumniYears(),
                ]);
            } else {
                return response('Forbidden', 403);
            }

        } catch (\Exception $e) {
            Log::error($e);

            return abort(404);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        return view('admin.events.newEventForm', [
            'school_id' => $request->school_id,
            'grades'    => Auth::user()->getSchool()->getAlumniYears(),
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function store(AlumniEventCreateRequest $request)
    {
        $data = $request->except('_token');
        $files = $request->file('file', []);
        $data['school_id'] = $request->school_id;
        $event = AlumniEvent::create($data);
        $schoolId = $data['school_id'];

        if (!array_key_exists('levels', $data)) {
            $levels = ['All'];
        } else {
            $levels = array_unique($data['levels']);
            if (in_array('All', $levels)) {
                $levels = ['All'];
            }
        }
        $grades = collect($levels)->map(function ($value) {
            return ['grade' => $value];
        })->toArray();

        $event->grades()->createMany($grades);

        $users = User::query()->whereHas('users_yearbooks', function ($q) use ($schoolId, $levels) {
            $q->whereHas('yearbook', function ($qq) use ($schoolId, $levels) {
                $qq->where('year_books.school_id', $schoolId);
                if (count($levels) && !in_array('All', $levels)) {
                    $qq->whereIn('year_to', $levels);
                }
            });
            $q->where('is_alumni', true);
        })->get();

        $users->each(function ($user) use ($event) {
            EventVisit::query()
                ->create(
                    [
                        'user_id' => $user->id,
                        'event_id' => $event->id,
                        'status' => EventsVisitStatus::NEW
                    ]
                );
        });

        User::alumniPushNotification($request->title, 'event', $request->school_id, $levels, AlumniPushType::Event);

        return redirect()->action('Admin\AlumniEventsController@index',
            ['id' => $request->school_id])
            ->with('success-message', 'Event successfully created');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int     $id
     * @param Request $request
     *
     * @return mixed
     */
    public function edit(Request $request, $id)
    {
        try {
            $feed = AlumniEvent::findOrFail($id);

            return view('admin.events.editEventForm', [
                'feed'      => $feed,
                'school_id' => $request->school_id,
            ]);
        } catch (Exception $exception) {
            Log::error($exception);

            return response($exception->getMessage(), 404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $event = AlumniEvent::findOrFail($id);
        } catch (Exception $exception) {
            Log::error($exception);
            abort(404);
        }

        $schoolId = $this->getSchoolId($request);

        $data = [
            'title'   => $request->title,
            'message' => $request->get('message', ''),
            'link'    => $request->get('link', ''),
            'attach'  => $request->get('attach', ''),
        ];

        $event->update($data);

        return redirect()
            ->action('Admin\AlumniEventsController@index', ['id' => $schoolId])
            ->with('success-message', 'Event successfully updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $id = $request->id ?? $id;
        $event = AlumniEvent::find($id);

        if (isset($event->attachments)) {
            foreach ($event->attachments as $attachment) {
                @unlink(public_path($attachment->path));
            }
        }

        $event->delete();

        return redirect()->back()
            ->with('success-message', 'Event successfully deleted');

    }

    /**
     * @param $id
     *
     * @return array
     */
    public function preview($id)
    {
        $feed = AlumniEvent::findOrFail($id);

        $attach = [];
        if ($feed->attach) {
            $attach = json_decode($feed->attach);
        }
        $imageUrls = '';
        foreach ($attach as $attachment) {
            $image = "background-image: url(" . $attachment->path . ")";
            $imageUrls .= "<div class=\"image\" style=\"height: 140px; margin-bottom: 5px; background-size: contain;background-repeat: no-repeat;background-position: center;"
                . $image . "\"></div>";
        }

        return [
            'title'     => $feed->title,
            'message'   => $feed->message,
            'link'      => $feed->link,
            'imageUrls' => $imageUrls,
        ];
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function attachDelete(Request $request): array
    {
        try {
            $attachment = EventAttachment::findOrFail($request->feedAttachId);
            @unlink(public_path($attachment->path));
            $attachment->delete();

            return ['status' => true];
        } catch (Exception $e) {
            Log::error($e);

            return ['status' => false];
        }
    }

    /**
     * @param Request $request
     *
     * @return integer
     */
    protected function getSchoolId(Request $request)
    {
        return $request->school_id ?? Auth::user()->user->school->school_id;
    }
}

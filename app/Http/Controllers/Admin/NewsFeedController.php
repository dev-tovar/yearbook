<?php

namespace App\Http\Controllers\Admin;

use App\Feed;
use App\FeedAttachment;
use App\Helpers\Yearbook;
use App\Http\Requests\NewsFeedStoreRequest;
use App\School;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class NewsFeedController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View|void
     */
    public function index(Request $request)
    {
        try {
            $school = School::findOrFail($request->id);
            if (policy(User::class)->get(Auth::user(), $school)) {
                $feeds = Feed::whereSchoolId($school->id)
                    ->filter($request->except('_token'))
                    ->paginate(10);

                return view('admin.feeds.index', [
                    'school'  => $school,
                    'feeds'   => $feeds,
                    'request' => $request,
                    'grades'  => Yearbook::$grades,
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('admin.feeds.newFeedForm', [
            'school_id' => $request->school_id,
            'grades'    => Yearbook::$grades,
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    protected function getSchoolId(Request $request)
    {
        if (isset($request->school_id)) {
            return $request->school_id;
        } else {
            return Auth::user()->user->school->school_id;
        }
    }

    /**
     * @param Feed $feed
     * @param $levels
     */
    protected function createGradeLevels(Feed $feed, $levels)
    {
        foreach ($levels as $level) {
            $feed->grades()->create([
                'grade' => $level,
            ]);
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function preview($id)
    {
        $feed = Feed::findOrFail($id);

        $attach = [];
        if ($feed->attach) {
            $attach = json_decode($feed->attach);
        }
        $imageUrls = '';
        foreach ($attach as $attachment) {
            $image     = "background-image: url(".$attachment->path.")";
            $imageUrls .= "<div class=\"image\" style=\" background-repeat: no-repeat;background-position: center;"
                .$image."\"></div>";
        }

        return [
            'title'     => $feed->title,
            'message'   => $feed->message,
            'link'      => $feed->link,
            'imageUrls' => $imageUrls,
        ];
    }

    /**
     * @param NewsFeedStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(NewsFeedStoreRequest $request)
    {
        $data               = $request->except('_token');
        $files              = $request->file('file', []);
        $data['school_id']  = $request->school_id;
        $data['recipients'] = is_array($data['recipient'])?$data['recipient'][0]:$data['recipient'];
        $feed = Feed::create($data);

        if ( ! key_exists('levels', $data)) {
            $levels = ['All'];
        } else {
            $levels = array_unique($data['levels']);
            if (in_array('All', $levels)) {
                $levels = ['All'];
            }
        }

        $this->createGradeLevels($feed, $levels);

        (new FeedAttachment())->uploadAndCreate($files, $feed, $data['school_id']);

        $isPush = !!$request->is_push;

        User::pushNewsFeed($feed, $data['school_id'], $isPush);

        return redirect()->action('Admin\NewsFeedController@index',
            ['id' => $request->school_id])
            ->with('success-message', 'Feed successfully created');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
//        $data = $request->all();
//        $data['some_id'] = $id;
//        dd($data);
        $feedId = $id;
        $files  = $request->file('file', []);
        try {
            $feed = Feed::findOrFail($feedId);
        } catch (\Exception $exception) {
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

        $feed->update($data);

        $feedAttach = new FeedAttachment();
        $feedAttach->uploadAndCreate($files, $feed, $schoolId);

        return redirect()
            ->action('Admin\NewsFeedController@index', ['id' => $schoolId])
            ->with('success-message', 'Feed successfully updated');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        try {
            $feed = Feed::findOrFail($id);

            return view('admin.feeds.editFeedForm', [
                'feed'      => $feed,
                'school_id' => $request->school_id,
            ]);
        } catch (\Exception $exception) {
            Log::error($exception);

            return response($exception->getMessage(), 404);
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, Request $request)
    {
        $id   = $request->id ? $request->id : $id;
        $feed = Feed::find($id);

        if (isset($feed->attachments)) {
            foreach ($feed->attachments as $attachment) {
                @unlink(public_path($attachment->path));
            }

            $feed->attachments()->delete();
        }

        if (isset($feed->grades)) {
            $feed->grades()->delete();
        }

        $feed->delete();

        return redirect()->back()
            ->with('success-message', 'Feed successfully deleted');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function attachDelete(Request $request)
    {
        try {
            $attachment = FeedAttachment::findOrFail($request->feedAttachId);
            @unlink(public_path($attachment->path));
            $attachment->delete();

            return ['status' => true];
        } catch (\Exception $e) {
            Log::error($e);

            return ['status' => false];
        }
    }
}

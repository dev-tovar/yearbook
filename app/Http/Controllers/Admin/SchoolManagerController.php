<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Http\Requests\UpdateSchoolManagerRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Contract;
use App\Models\FileContracts;
use App\Helpers\Yearbook;
use App\Http\Requests\StoreSchoolManagerRequest;
use App\Models\School;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SchoolManagerController extends Controller
{
    public function index(Request $request)
    {


        // dd(Auth::guard('admin')->user()->hasRole('super-admin'));
        // $this->authorize('yearbook.publish');
        if ($request->has('filter')) {
            $schools = School::filter($request->all())
                //	            ->toSql();
                //            dd($schools);
                ->get();
        } else {
            $schools = School::withCount('totalUsers')->with('contract')->orderBy('created_at', 'desc')->paginate(10);
        }

        return  [
            'schools' => $schools,
            'request' => $request,
            'grades' => Yearbook::$gradesFilter
        ];

        // return view('admin.school_manager.index', [
        //     'schools' => $schools,
        //     'request' => $request,
        //     'grades' => Yearbook::$gradesFilter
        // ]);
    }

    public function create()
    {
        // $this->authorize('yearbook.publish');
        $states = Yearbook::$states;
        $grades = Yearbook::$grades;


        return [
            'states' => $states,
            'grades' => Yearbook::$gradesFilter
        ];

        // return view('admin.school_manager.createForm', [
        //     'states' => $states,
        //     'grades' => Yearbook::$gradesFilter
        // ]);
    }

    public function edit($id)
    {
        try {
            /** @var School $school */
            $school = School::withCount('totalUsers')->with('contract')->findOrFail($id);
            $states = Yearbook::$states;
            $grades = Yearbook::$grades;

            $school->grades = $school->socialGrades()->pluck('grade')->toArray();

            if (policy(User::class)->get(Auth::user(), $school)) {
                return [
                    'school' => $school,
                    // 'states' => $states,
                    // 'grades' => Yearbook::$gradesFilter,
                    'socialGrades' => $grades
                ];

                // return view('admin.school_manager.editForm', [
                //     'school' => $school,
                //     'states' => $states,
                //     'grades' => Yearbook::$gradesFilter,
                //     'socialGrades' => $grades,
                // ]);
            } else {
                return response('Forbidden', 403);
            }
        } catch (\Exception $exception) {
            Log::error($exception);
            return response($exception->getMessage(), 404);
        }
    }

    public function destroy($id)
    {
        School::find($id)->delete();
        return redirect()
            ->action('Admin\SchoolManagerController@index')
            ->with('success-message', 'School successfully deleted');
    }

    public function store(StoreSchoolManagerRequest $request)
    {
        $data = $request->all();
        $school = School::createSchoolWithData($data);
        if (!$school) {

            return response([
                "status" => "error-message",
                "message" => sprintf('School was not created')
            ], 404);

            // return redirect()->action('Admin\SchoolManagerController@index')
            //     ->with(
            //         'error-message',
            //         sprintf('School was not created')
            //     );
        }
        if ($request->hasFile('file')) {
            $file = new FileContracts();
            $file->uploadFile($request->file('file'), $school->id);
        }

        return response([
            "status" => "success-message",
            "message" => sprintf('School <strong>"%s"</strong> was </br> successfully created', $school->name)
        ], 200);

        // return redirect()->action('Admin\SchoolManagerController@index')
        //     ->with(
        //         'success-message',
        //         sprintf('School <strong>"%s"</strong> was successfully created', $school->name)
        //     );

    }

    public function update(UpdateSchoolManagerRequest $request, $id)
    {
        //    dd($request);
        $school = School::findOrFail($id);
        if (Auth::guard('admin')->user()->hasRole('admin')) {
            $school->update([
                'name' => $request->name,
                'grade' => $request->grade,
                'students_number' => $request->students_number,
                'state' => $request->state,
                'city' => $request->city,
                'address' => $request->address,
                'zip' => $request->zip,
                'advisor' => $request->advisor,
                'is_fb' => $request->is_fb,
                'is_twitter' => $request->is_twitter,
                'is_inst' => $request->is_inst,
                'is_linkedin' => $request->is_linkedin,
            ]);
        } else {
            $school->update([
                'name' => $request->name,
                'grade' => $request->grade,
                'students_number' => $request->students_number,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'address' => $request->address,
                'zip' => $request->zip,
                'advisor' => $request->advisor,
                'contract_years' => $request->contract_years,
                'contract_start_date' => $request->contract_start_date,
                'is_fb' => $request->is_fb,
                'is_twitter' => $request->is_twitter,
                'is_inst' => $request->is_inst,
                'is_linkedin' => $request->is_linkedin,
            ]);
        }

        $school->socialGrades()->delete();
        foreach ($request->social_grade ?? [] as $gr) {
            $school->socialGrades()->create(['grade' => $gr]);
        }
        if ($request->hasFile('file')) {
            $file = new FileContracts();
            $file->uploadFile($request->file('file'), $id);
        }


        if (Auth::guard('admin')->user()->hasRole('admin')) {
            // dd('Admin is');
            return response([
                'status' => "success",
                'message' => 'School was </br> successfully updated'
            ], 200);
            // return redirect()->back()
            //     ->with(['id' => $id])
            //     ->with(['success-message' => 'School was successfully updated']);

        } else {
            return response([
                'status' => "success",
                'message' => sprintf('School <strong>"%s"</strong> was </br> successfully updated', $school->name)
            ], 200);
            // return redirect()->action('Admin\SchoolManagerController@index')
            //     ->with('success-message', sprintf('School <strong>"%s"</strong> was successfully updated', $school->name));
        }
    }

    public function books($id)
    {
        $school = School::find($id);

        if (policy(User::class)->get(Auth::user(), $school)) {
            return view('admin.school.books_list', [
                'school' => $school
            ]);
        } else {
            return response('Forbidden', 403);
        }
    }

    public function removeContract($id)
    {
        $contract = Contract::find($id);

        if ($contract) {
            File::delete(public_path($contract->path));
            $contract->delete();
        }

        return ['status' => true];
    }

    public function contract(Request $request, $id)
    {
        if ($request->hasFile('file')) {
            $file = new FileContracts();
            $file->uploadFile($request->file('file'), $id);
        }

        return ['status' => true];
    }
}

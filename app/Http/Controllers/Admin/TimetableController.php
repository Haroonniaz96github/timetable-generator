<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Day;
use App\Models\Timetable;
use App\Models\AcademicPeriod;
use App\Models\Course;
use App\Models\Professor;
use App\Models\CollegeClass;
use Illuminate\Support\Facades\Storage;
use App\Services\GeneticAlgorithm\TimeTableRenderer;
use App\Services\GeneticAlgorithm\TimetableGA;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Events\TimetablesRequested;

class TimetableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $timetables = Timetable::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.timetable.index', compact('timetables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $timetables = Timetable::orderBy('created_at', 'DESC')->paginate(10);
        $days = Day::all();
        $academicPeriods = AcademicPeriod::all();
        return view('admin.timetable.create', compact('timetables', 'days', 'academicPeriods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd("sss");
        $rules = [
            'name' => 'required',
            'academic_period_id' => 'required'
        ];

        $messages = [
            'academic_period_id.required' => 'An academic period must be selected'
        ];

        $this->validate($request, $rules, $messages);

        $errors = [];
        $dayIds = [];

        $days = Day::all();

        foreach ($days as $day) {
            if ($request->has('day_' . $day->id)) {
                $dayIds[] = $day->id;
            }
        }

        if (!count($dayIds)) {
            $errors[] = 'At least one day should be selected';
        }

        if (count($errors)) {
            return redirect()->back()->withErrors($errors);
            return redirect()->back();
        }

        $otherChecks = $this->checkCreationConditions();
        $combinedErrors = array_merge($errors, $otherChecks);

        if (count($combinedErrors)) {
            return redirect()->back()->withErrors($combinedErrors);
        }

        $timetable = Timetable::create([
            'user_id' => Auth::user()->id,
            'academic_period_id' => $request->academic_period_id,
            'status' => 'IN PROGRESS',
            'name' => $request->name
        ]);

        if ($timetable) {
            $timetable->days()->sync($dayIds);
        }
        set_time_limit(3000);
        event(new TimetablesRequested($timetable));
        Session::flash('success_message', 'Timetables are being generated.Check back later!');
        return redirect(route('timetables.index'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class = Timetable::findOrFail($id);
        $class->delete();
        Session::flash('success_message', 'Timetable successfully deleted!');
        return redirect()->route('timetables.index');
    }

    public function DeleteSelectedTimeTables(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'timetables' => 'required',

        ]);
        foreach ($input['timetables'] as $index => $id) {

            $course = Timetable::findOrFail($id);
            $course->delete();

        }
        Session::flash('success_message', 'Timetable successfully deleted!');
        return redirect()->back();

    }

    public function view($id)
    {
        $timetable = Timetable::find($id);

        if (!$timetable) {
            return redirect('/');
        } else {
            $path = $timetable->file_url;
            $timetableData =  Storage::get($path);
            $timetableName = $timetable->name;
            return view('admin.timetable.view', compact('timetableData', 'timetableName'));
        }
    }

    public function checkCreationConditions()
    {
        $errors = [];

        $coursesQuery = 'SELECT id FROM courses WHERE id NOT IN (SELECT DISTINCT course_id FROM courses_professors)';
        $courseIds = DB::select($coursesQuery);

        if (count($courseIds)) {
            $errors[] = "Some courses don't have professors.<a href=\"/courses?filter=no_professor\" target=\"_blank\">Click here to review them</a>";
        }

        if (!CollegeClass::count()) {
            $errors[] = "No classes have been added";
        }

        $classesQuery = 'SELECT id FROM classes WHERE id NOT IN (SELECT DISTINCT class_id FROM courses_classes)';
        $classIds = DB::select($classesQuery);

        if (count($classIds)) {
            $errors[] = "Some classes don't have any course set up.<a href=\"/classes?filter=no_course\" target=\"_blank\">Click here to review them</a>";
        }
        return $errors;
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Course;
use App\Models\CollegeClass;
use App\Models\AcademicPeriod;
use Illuminate\Support\Facades\Session;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = CollegeClass::all();
        $rooms = Room::all();
        $courses = Course::all();
        $academicPeriods = AcademicPeriod::all();
        return view('admin.classes.index', compact('rooms', 'courses', 'academicPeriods', 'classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = CollegeClass::all();
        $rooms = Room::all();
        $courses = Course::all();
        $academicPeriods = AcademicPeriod::all();
        return view('admin.classes.create', compact('rooms', 'courses', 'academicPeriods', 'classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request data
        $this->validate($request, [
            'name' => 'required|unique:classes',
            'size' => 'required',
            'courses' => 'required|array'
        ]);

        // Create a new CollegeClass instance
        $class = new CollegeClass();
        $class->name = $request->input('name');
        $class->size = $request->input('size');
        $class->save();

        // Sync courses
        foreach ($request->input('courses') as $key => $course) {
            // Attach records to the pivot table 'courses_classes'
            $class->courses()->attach(
                $course,
                [
                    'academic_period_id' => $request->input('periods')[$key],
                    'meetings' => $request->input('meetings')[$key],
                ]
            );
        }

        // Check if 'room_ids' is provided before syncing
        if ($request->has('room_ids')) {
            $class->unavailable_rooms()->sync($request->input('room_ids'));
        }

        // Flash success message
        Session::flash('success_message', 'Great! Class has been added successfully!');

        // Redirect back
        return redirect()->back();
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
        $class = CollegeClass::with('courses')->findOrFail($id);
        // dd( );
        $rooms = Room::all();
        $courses = Course::all();
        $academicPeriods = AcademicPeriod::all();
    
        return view('admin.classes.edit', compact('class', 'rooms', 'courses', 'academicPeriods'));
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
        // Validate request data
        $this->validate($request, [
            'name' => 'required|unique:classes,name,' . $id,
            'size' => 'required',
            'courses' => 'required|array'
        ]);

        // Find the class by ID
        $class = CollegeClass::findOrFail($id);

        // Update class information
        $class->name = $request->input('name');
        $class->size = $request->input('size');
        $class->save();

        // Sync courses
        $coursesData = [];
        foreach ($request->input('courses') as $key => $course) {
            $coursesData[$course] = [
                'academic_period_id' => $request->input('periods')[$key],
                'meetings' => $request->input('meetings')[$key],
            ];
        }
        $class->courses()->sync($coursesData);

        // Check if 'room_ids' is provided before syncing
        if ($request->has('room_ids')) {
            $class->unavailable_rooms()->sync($request->input('room_ids'));
        }

        // Flash success message
        Session::flash('success_message', 'Class has been updated successfully!');

        // Redirect back
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class = CollegeClass::findOrFail($id);
        $class->delete();
        Session::flash('success_message', 'Class successfully deleted!');
        return redirect()->route('classes.index');
    }

    public function DeleteSelectedClasses(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'classes' => 'required',

        ]);
        foreach ($input['classes'] as $index => $id) {

            $course = CollegeClass::findOrFail($id);
            $course->delete();

        }
        Session::flash('success_message', 'Classes successfully deleted!');
        return redirect()->back();

    }
}

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
        $this->validate($request, [
            'name' => 'required|unique:classes',
            'size' => 'required'
        ]);
        $input = $request->all();
        $class = new CollegeClass();
        $class->name = $input['name'];
        $class->size = $input['size'];
        $class->save();
        
        $class->unavailable_rooms()->sync($input['room_ids']);
        $class->courses()->sync($input['courses']);

        Session::flash('success_message', 'Great! Class has been added successfully!');
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

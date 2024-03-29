<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Professor;
use Illuminate\Support\Facades\Session;

class CourseController extends Controller
{
    private $obj;

    public function __construct(Course $object)
    {
        // $this->middleware('auth:admin');
        $this->obj = $object;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses=$this->obj->latest()->get();
        return view('admin.courses.index',['courses'=>$courses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $professors = Professor::all();
        return view('admin.courses.create', ['professors' => $professors]);
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
            'name' => 'required|max:255',
            'code' => 'required|max:255',
            'professor_ids' => 'required|max:255',
        ]);

        $input = $request->all();
        $course = new Course();
        $course->name = $input['name'];
        $course->course_code = $input['code'];

        $course->save();
        if (!isset($input['professor_ids'])) {
            $input['professor_ids'] = [];
        }
        $course->professors()->sync($input['professor_ids']);
        // dd($request);
        Session::flash('success_message', 'Great! Course has been saved successfully!');
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
        $course = $this->obj->find($id);
        $professors = Professor::all(); // Assuming you have a Professor model and a professors table
        $professorIds = [];

        if (!$course) {
            return null;
        }

        foreach ($course->professors as $professor) {
            $professorIds[] = $professor->id;
        }

        $course->professor_ids = $professorIds;
        return view('admin.courses.edit', [
            'title' => 'Update Course Details',
            'course' => $course,
            'professors' => $professors,
        ]);
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
        $course = $this->obj->findOrFail($id);
        $this->validate($request, [
            'name' => 'required|max:255',
            'code' => 'required|max:255',
        ]);
        $input = $request->all();

        $course->name = $input['name'];
        $course->course_code = $input['code'];
        $course->save();
        if (!isset($input['professor_ids'])) {
            $input['professor_ids'] = [];
        }


        $course->professors()->sync($input['professor_ids']);
        Session::flash('success_message', 'Great! course successfully updated!');
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
        $course = $this->obj->findOrFail($id);
        $course->delete();
        Session::flash('success_message', 'Course successfully deleted!');
        return redirect()->route('courses.index');
    }
    
    public function DeleteSelectedCourses(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'courses' => 'required',

        ]);
        foreach ($input['courses'] as $index => $id) {

            $course = $this->obj->findOrFail($id);
            $course->delete();

        }
        Session::flash('success_message', 'Courses successfully deleted!');
        return redirect()->back();

    }

    public function courseDetail(Request $request)
    {
        $course = Course::findOrFail($request->input('id'));

        return view('admin.courses.single', ['title' => 'Course Detail', 'course' => $course]);
    }

    public function classes(){
        return view('admin.classes.create');
    }
}

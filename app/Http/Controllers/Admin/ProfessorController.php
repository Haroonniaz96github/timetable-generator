<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Day;
use App\Models\Course;
use App\Models\Timeslot;
use App\Models\Professor;
use App\Models\UnavailableTimeslot;

class ProfessorController extends Controller
{
    private $obj;

    public function __construct(Professor $object)
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
        $professors=$this->obj->latest()->get();
        return view('admin.professors.index',['professors'=>$professors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::all();
        $professors = Professor::all();
        $days = Day::all();
        $timeslots = Timeslot::all();
        return view('admin.professors.create', compact('professors', 'courses', 'days', 'timeslots'));
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
            // 'email' => 'required|max:255',
        ]);

        $input = $request->all();
        $professor = new Professor();
        $professor->name = $input['name'];
        $professor->email = $input['email'];
        $professor->save();
        if (isset($input['course_ids'])) {
            $professor->courses()->sync($input['course_ids']);
        }

        if (isset($input['unavailable_periods'])) {
            foreach ($input['unavailable_periods'] as $period) {
                $parts = explode("," , $period);
                $dayId = $parts[0];
                $periodId = $parts[1];

                $professor->unavailable_timeslots()->create([
                    'day_id' => $dayId,
                    'timeslot_id' => $periodId
                ]);
            }
        }

        Session::flash('success_message', 'Great! Professor has been saved successfully!');
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
        $professor = $this->obj->find($id);
        $courses = Course::all();
        $professors = Professor::all();
        $days = Day::all();
        $timeslots = Timeslot::all();
        $professor = Professor::find($id);
        $courseIds = [];
        $periods = [];

        if (!$professor) {
            return null;
        }

        foreach ($professor->courses as $course) {
            $courseIds[] = $course->id;
        }

        foreach ($professor->unavailable_timeslots as $period) {
            $periods[] = implode(",", [$period->day_id, $period->timeslot_id]);
        }

        $professor->course_ids = $courseIds;
        $professor->periods = $periods;
        return view('admin.professors.edit', compact('professors', 'courses', 'days', 'timeslots', 'professor'));
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
        $professor = $this->obj->findOrFail($id);
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|max:255',            
        ]);
        $input = $request->all();

        $professor->name = $input['name'];
        $professor->email = $input['email'];
        $professor->save();
        if (!isset($data['course_ids'])) {
            $data['course_ids'] = [];
        }

        $professor->courses()->sync($input['course_ids']);

        if (isset($input['unavailable_periods'])) {
            foreach ($input['unavailable_periods'] as $period) {
                $parts = explode("," , $period);
                $dayId = $parts[0];
                $timeslotId = $parts[1];

                $existing = $professor->unavailable_timeslots()
                    ->where('day_id', $dayId)
                    ->where('timeslot_id', $timeslotId)
                    ->first();

                if (!$existing) {
                    $professor->unavailable_timeslots()->create([
                        'day_id' => $dayId,
                        'timeslot_id' => $timeslotId
                    ]);
                }
            }

            foreach ($professor->unavailable_timeslots as $period) {
                if ($period->day && $period->timeslot) {
                    $periodString = implode("," , [$period->day->id, $period->timeslot->id]);
                }

                if (!isset($input['unavailable_periods']) || !in_array($periodString, $input['unavailable_periods'])) {
                    $period->delete();
                }
            }
        } else {
            foreach ($professor->unavailable_timeslots as $period) {
                $period->delete();
            }
        }

        Session::flash('success_message', 'Great! professor successfully updated!');
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
        $professor = $this->obj->findOrFail($id);
        $professor->delete();
        Session::flash('success_message', 'Professor successfully deleted!');
        return redirect()->route('professors.index');
    }
    
    public function DeleteSelectedProfessors(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'professors' => 'required',

        ]);
        foreach ($input['professors'] as $index => $id) {

            $professor = $this->obj->findOrFail($id);
            $professor->delete();

        }
        Session::flash('success_message', 'Professors successfully deleted!');
        return redirect()->back();

    }

    public function professorDetail(Request $request)
    {
        $professor = Professor::findOrFail($request->input('id'));

        return view('admin.professors.single', ['title' => 'Professor Detail', 'professor' => $professor]);
    }
}

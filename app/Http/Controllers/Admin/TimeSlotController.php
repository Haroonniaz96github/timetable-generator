<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TimeSlotController extends Controller
{

    private $obj;

    public function __construct(TimeSlot $object)
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
        $timeslots=$this->obj->latest()->get();
        return view('admin.time_slots.index',['timeslots'=>$timeslots]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.time_slots.create');
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
            'from' => 'required|before:to',
            'to' => 'required|after:from'
        ]);

        $exists = Timeslot::where('time', createTimePeriod($request->from, $request->to))->first();

        if ($exists) {
            Session::flash('error_message', 'This timeslot already exists!');
        }

        $data = $request->all();

        $data['time'] = createTimePeriod($data['from'], $data['to']);

        $timeslots = Timeslot::all();

        foreach ($timeslots as $timeslot) {
            if (TimeSlot::containsPeriod($data['time'])) {
                $errors = [ $data['time'] . ' falls within another timeslot (' . $timeslot->time
                    . ').Please adjust timeslots'];
                return Session::flash('error_message', $errors);
            }
        }

        $input = $request->all();
        $time_slot = new TimeSlot();
        $time_slot->time =  $data['time'];
        $time_slot->rank = 1;
        $time_slot->save();

        Session::flash('success_message', 'Great! TimeSlot has been saved successfully!');
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
        $time_slot = $this->obj->findOrFail($id);
        $time_slot->delete();
        Session::flash('success_message', 'Time Slot successfully deleted!');
        return redirect()->route('time-slots.index');
    }
    
    public function DeleteSelectedProfessors(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'time_slots' => 'required',

        ]);
        foreach ($input['time_slots'] as $index => $id) {

            $professor = $this->obj->findOrFail($id);
            $professor->delete();

        }
        Session::flash('success_message', 'Time Slots successfully deleted!');
        return redirect()->back();

    }

    public function timeSlotDetail(Request $request)
    {
        $time_slot = TimeSlot::findOrFail($request->input('id'));

        return view('admin.time_slots.single', ['title' => 'Professor Detail', 'time_slot' => $time_slot]);
    }
}

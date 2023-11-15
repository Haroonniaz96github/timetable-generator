<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Events\TimeslotsUpdated;
use App\Services\TimeslotsService;
use App\Models\Day;

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
        $rules = [
            'from' => 'required|before:to',
            'to' => 'required|after:from'
        ];

        $messages = [
            'from.before' => 'From time must be before To time',
            'to.after' => 'To time must be after From time'
        ];

        $this->validate($request, $rules, $messages);

        $exists = Timeslot::where('time', Timeslot::createTimePeriod($request->from, $request->to))->first();

        if ($exists) {
            Session::flash('error_message', 'Error! This timeslot already exists');
            return redirect()->back();
        }

        $data = $request->all();
        $data['time'] = Timeslot::createTimePeriod($data['from'], $data['to']);

        $timeslots = Timeslot::all();

        foreach ($timeslots as $timeslot) {
            if ($timeslot->containsPeriod($data['time'])) {
                $errors = [$data['time'] . ' falls within another timeslot (' . $timeslot->time
                    . ').Please adjust timeslots'];
                Session::flash('error_message', 'Error! This timeslot already exists');
                return redirect()->back();
            }
        }

        $input = $request->all();
        $time_slot = new TimeSlot();
        $time_slot->time =  $data['time'];

        if ($time_slot->save()) {
            event(new TimeslotsUpdated());
            Session::flash('success_message', 'Great! TimeSlot has been saved successfully!');
            return redirect()->back();
        } else {
            Session::flash('error_message', 'Error! Something went wrong');
            return redirect()->back();
        }
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

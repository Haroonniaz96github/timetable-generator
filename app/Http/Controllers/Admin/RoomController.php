<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\Session;

class RoomController extends Controller
{
    private $obj;

    public function __construct(Room $object)
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
        $rooms=$this->obj->latest()->get();
        return view('admin.rooms.index',['rooms'=>$rooms]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.rooms.create');
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
            'capacity' => 'required|max:255',
        ]);

        $input = $request->all();
        $room = new Room();
        $room->name = $input['name'];
        $room->capacity = $input['capacity'];
        $room->save();

        Session::flash('success_message', 'Great! Room has been saved successfully!');
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
        $room = $this->obj->find($id);

        return view('admin.rooms.edit', ['title' => 'Update Room Details', 'room' => $room]);
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
        $room = $this->obj->findOrFail($id);
        $this->validate($request, [
            'name' => 'required|max:255',
            'capacity' => 'required|max:255',
        ]);
        $input = $request->all();

        $room->name = $input['name'];
        $room->capacity = $input['capacity'];
        $room->save();

        Session::flash('success_message', 'Great! room successfully updated!');
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
        $room = $this->obj->findOrFail($id);
        $room->delete();
        Session::flash('success_message', 'Room successfully deleted!');
        return redirect()->route('rooms.index');
    }
    
    public function DeleteSelectedRooms(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'rooms' => 'required',

        ]);
        foreach ($input['rooms'] as $index => $id) {

            $room = $this->obj->findOrFail($id);
            $room->delete();

        }
        Session::flash('success_message', 'Rooms successfully deleted!');
        return redirect()->back();

    }

    public function roomDetail(Request $request)
    {
        $room = Room::findOrFail($request->input('id'));

        return view('admin.rooms.single', ['title' => 'Room Detail', 'room' => $room]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Professor;

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
        return view('admin.professors.create');
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
            'email' => 'required|max:255',
        ]);

        $input = $request->all();
        $professor = new Professor();
        $professor->name = $input['name'];
        $professor->email = $input['email'];
        $professor->save();

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

        return view('admin.professors.edit', ['title' => 'Update Professor Details', 'professor' => $professor]);
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

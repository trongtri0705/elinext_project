<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\LevelRequest;
use App\Level,App\Role;
class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->role_id !=4)
        {
            return view('html.error-403');
        }
        $title = "Level";
        $data = Level::all();
        $list = Role::all();
        return view('html.level.list',compact('data','title','list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()->role_id !=4)
        {
            return view('html.error-403');
        }
        $title = "Create Level";
        $role = Role::where('id','<>','4')->get();
        return view('html.level.add-edit',compact('role','title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LevelRequest $request)
    {
        $role = $request->sltRole;        
        $array = explode(",", $request->txtName);
        foreach ($array as $key => $value) {
            $model = new Level;
            $model->name = $value;        
            $model->role_id = $role;
            $model->save();
        } 
        return redirect()->route('admin.level.index')->with('success','Added completely!');
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
    public function edit(Level $level)
    {
        if(\Auth::user()->role_id !=4)
        {
            return view('html.error-403');
        }
        $title = "Edit Level";
        $role = Role::where('id','<>','4')->get();
        return view('html.level.add-edit',compact('level','role','title'));
    }
    /*
     *update function
     */
    public function update(LevelRequest $request, Level $level){        
       
        $level->name = $request->txtName;
        $level->role_id = $request->sltRole;
        $level->save();
        return redirect()->route('admin.level.index')->with('success','Edited completely!');
    }
    public function destroy(Level $level){
        if(\Auth::user()->role_id !=4)
        {
            return view('html.error-403');
        }
        $level->delete();
        return redirect()->route('admin.level.index')->with('success','Deleted completely!');
    }
    public function clear(Request $request)
    {
        if(\Auth::user()->role_id !=4)
        {
            return view('html.error-403');
        }
        foreach ($request->input('checkbox') as $key => $value) {
            $model = Level::find($value);
            $model->delete();
        }
        return redirect()->route('admin.level.index')->with('success','successfully deleted');
    }
}

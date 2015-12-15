<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User,App\Department,App\Manager,App\TeamDetail;
use Auth;
use App\Team;
class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $list = User::where('role_id',3)->get();
        $title = "Managers";
        return view('html.team.manager.index',compact('list','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role_id != 3)
        {
            return view('html.error-403');
        }
        $title = "Create Manager's Team";
        $developer = User::where('role_id',1)->get();
        return view('html.team.manager.add-edit',compact('title','developer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
            ["txtName"=>"required|unique:teams,name",
            'staff'=>'required'],
            ["txtName.required"=>"Please enter cate's name.",
            'txt.unique'=>'This name has already been taken',
            'staff.required'=>'Please select staff']);
        $team = new Manager;
        $team->name = $request->txtName;
        $team->created_user_id = Auth::user()->id;
        $team->save();

        foreach ($request->input('staff') as $key => $value)
        {
            $detail = new TeamDetail;
            $detail->team_id = $team->id;
            $detail->staff_id = $value;
            $detail->save();
        }

        return redirect()->route('admin.team.index')->with('success','Posted completely!');
    }
     public function getAdd($id)
    {
       if(\Auth::user()->role_id !=3)
        {
            return view('html.error-403');
        }
        $team = Team::find($id);
        $title = "Create Manager's Team";
        $list = TeamDetail::select('staff_id')->where('team_id',$id)->get()->toArray();
        $developer = User::where('role_id',1)->whereNotIn('id',$list)->get();
        return view('html.team.manager.add-edit',compact('title','developer','team','id'));
    }
    public function postAdd(Request $request, $id)
    {
        $this->validate($request,
            ['staff'=>'required'],
            ['staff.required'=>'Please select staff']);
       foreach ($request->input('staff') as $key => $value)
        {
            $detail = new TeamDetail;
            $detail->team_id = $id;
            $detail->staff_id = $value;
            $detail->save();
        }

        return redirect()->route('admin.team.index')->with('success','Added completely!');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function show(Staff $staff)
    {
        //
        return view('html.staff.detail',compact('staff'));
    }
    public function edit(User $staff)
    {
        $title = "Staff";
        return view('html.staff.add',compact('staff','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user){        
       
        $user->name = $request->txtName;
        $user->birthday = $request->txtBirth;
        $user->phone = $request->txtPhone;
        $user->save();
        return redirect()->route('admin.staff.index')->with('success','Edited completely!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $list = TeamDetail::where('team_id',$id)->get();
        foreach ($list as $key => $value) {
            $value->delete();
        }
        Leader::find($id)->delete();
        return redirect()->route('admin.team')->with('success','successfully deleted');
    }
    public function destroy($id,$user)
    {
        $team = Team::find($id);
        if($team->created_user_id!=Auth::user()->id)
            return view('html.error-403');
        \App\TeamDetail::where(['team_id'=>$id,'staff_id'=>$user])->delete();
        return redirect()->route('admin.team.index')->with('success','successfully deleted');
        
    }
    public function getList()
    {
        
    }    
}

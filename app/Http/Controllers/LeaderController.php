<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User,App\Department,App\Leader,App\TeamDetail;
use Auth,Hash,Mail;
use App\Team;
use App\Http\Requests\UserRequest;
use App\Profile;
class LeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = User::where('role_id',2)->get();
        $title = "Leaders";
        return view('html.team.leader.index',compact('list','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()->role_id !=2)
        {
            return view('html.error-403');
        }
        $title = "Create Leader's Team";
        $developer = User::where(['role_id'=>1,'department_id'=>Auth::user()->department_id])->get();
        return view('html.team.leader.add-edit',compact('title','developer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $this->validate($request,
            ["txtName"=>"required|unique:teams,name",
            'staff'=>'required'],
            ["txtName.required"=>"Please enter cate's name.",
            'txtName.unique'=>'This name has already been taken',
            'staff.required'=>'Please select staff']);
        $team = new Leader;
        $team->name = $request->txtName;
        $team->created_user_id = Auth::user()->id;
        $team->save();

        foreach (Request::input('staff') as $key => $value)
        {
            $detail = new TeamDetail;
            $detail->team_id = $team->id;
            $detail->staff_id = $value;
            $detail->save();
        }

        return redirect()->route('admin.index')->with('success','Posted completely!');
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
    public function update(\Illuminate\Http\Request $request, User $user){        
       
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
    public function destroy($id,$user)
    {
        $team = Team::find($id);
        if($team->created_user_id!=Auth::user()->id)
            return view('html.error-403');
        \App\TeamDetail::where(['team_id'=>$id,'staff_id'=>$user])->delete();
        return redirect()->route('admin.index')->with('success','successfully deleted');
        
    }
   
    public function getAdd($id)
    {
        if(\Auth::user()->role_id !=2)
        {
            return view('html.error-403');
        }
        $team = Leader::find($id);
        $title = "Create Leader's Team";
        $list = TeamDetail::select('staff_id')->where('team_id',$id)->get()->toArray();
        $developer = User::where('role_id',1)->whereNotIn('id',$list)->get();
        return view('html.team.leader.add-edit',compact('title','developer','team','id'));
    }
    public function postAdd(\Illuminate\Http\Request $request, $id)
    {
        $this->validate($request,
            ['staff'=>'required'],
            ['staff.required'=>'Please select staff']);
       foreach (Request::input('staff') as $key => $value)
        {
            $detail = new TeamDetail;
            $detail->team_id = $id;
            $detail->staff_id = $value;
            $detail->save();
        }

        return redirect()->route('admin.index')->with('success','Added completely!');
    }
    public function getAddMember()
    {
        $dep = Department::find(Auth::user()->department_id);
        $title = "Add Developer To ".$dep->name." Department";
        return view('html.team.leader.add-member',compact('dep','title'));
    }
    public function postAddMember(UserRequest $request)
    {
        if($request->sltDepartment!=Auth::user()->department_id || $request->sltRole!=1)
            return redirect()->back()->with('danger','Dont try to be a hacker,please!');
        $model = new User();
        $model->email = $request->txtEmail;       
        $model->password = Hash::make($request->txtPass);
        $model->name = $request->txtName;
        $model->role_id = $request->sltRole;
        $model->level_id = $request->rdbLevel;
        $model->phone = $request->txtPhone;
        $model->birthday = $request->txtBirth;
        $model->department_id = $request->sltDepartment;
        $model->save();
        $profile = new Profile;
        $profile->user_id = $model->id;
        if($profile->save())
        {
            $data = [
                'name'   => Request::input('txtName'),
                'password' => Request::input('txtPass'),
                'email'=> Request::input('txtEmail')
                ];
            Mail::send('emails.blanks',$data,function($message){
                $message->from('trongtri0705@gmail.com','Nguyen Trong Tri');
                $message->to(Request::input('txtEmail'),Request::input('txtName'))->subject('This is mail');
            });
        }        
        return redirect()->route('admin.index')->with('success','Added completely!');
    }
    public function delete($id)
    {
        $list = TeamDetail::where('team_id',$id)->get();
        foreach ($list as $key => $value) {
            $value->delete();
        }
        Leader::find($id)->delete();
        return redirect()->route('admin.index')->with('success','successfully deleted');
    }
}

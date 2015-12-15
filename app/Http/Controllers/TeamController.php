<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User,App\Department,App\Team,App\TeamDetail;
use Auth;
class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role_id<2)
            return redirect()->back()->with('danger','You\'re not allowed to access this task.');
        $list = Team::where('created_user_id',Auth::user()->id)->with('detail')->get();
        $title = "My Teams";        
        return view('html.team.index',compact('list','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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

        return redirect()->route('admin.team.manager.index')->with('success','Posted completely!');
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
    public function destroy($id)
    {
        //
        $user_cur = Auth::user()->id;
        $user = User::find($id);
        if(($id == 1)||($id == $user_cur)||($user_cur!=1 && $user['lever']==1)){
            return redirect()->route('admin.user.list')->with('danger','alert!!! not allowed');
        }
        else{
        $user->delete($id);
        return redirect()->route('admin.user.list')->with('success','successfully deleted');
        }
    }
    public function delete($id)
    {
        $list = TeamDetail::where('team_id',$id)->get();
        foreach ($list as $key => $value) {
            $value->delete();
        }
        Team::find($id)->delete();
        return redirect()->route('admin.team.index')->with('success','successfully deleted');
    }
    public function clear(Request $request)
    {
        if(!$request->input('checkbox'))
        {
            return redirect()->back()->with('danger','You forgot chosing items');
        }
        foreach ($request->input('checkbox') as $key => $value) {
            $model = TeamDetail::find($value);
            $model->delete();
        }
        return redirect()->route('admin.team.index')->with('success','successfully deleted');
    }
    public function getAdd()
    {
        return view('admin/user/add');
    }
    public function postAdd(UserRequest $request)
    {
        $user = new User();
        $user->username = $request->txtUser;
        $user->password = Hash::make($request->txtPass);        
        $user->email = $request->txtEmail;
        $user->level = $request->rdoLevel;
        $user->save();
        return redirect()->route('admin.user.list')->with('success','Created User completely!');
    }
    public function getList()
    {
        
    }
    // public function getEdit($id){
    //     $data = User::find($id);
    //     if((Auth::user()->id !=1)&& ($id == 1 ||($data["level"]==1 && Auth::user()->id != $id))){
    //         return redirect()->route('admin.user.list')->with('danger','Sorry! You r not allowed to modify this user');;
    //     }
    //     return view('admin.user.edit',compact('data','id'));
    // }
    // public function postEdit($id,Request $request){
    //     $user = User::find($id);
    //     if($request->input('txtPass')){
            
    //         $this->validate($request,
    //         ["txtRePass"=>"same:txtPass"],
    //         ["txtRePass.same"=>"Password isn't match"]);
    //         $pass = $request->input('txtPass');
    //         $user->password = Hash::make($pass);

    //     }
    //     $user->level = $request->rdoLevel;
    //     $user->email = $request->txtEmail;
    //     $user->remember_token = $request->input('_token');
    //     $user->save();
    //     return redirect()->route('admin.user.list')->with('success','Edited completely!');;

    // }
}

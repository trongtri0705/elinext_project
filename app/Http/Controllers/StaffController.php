<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User,App\Department,App\Role;
use Auth;
use App\Http\Requests\UserRequest;
use Hash;
use App\Level;
use Input;
use File;
use Mail;
use App\Profile;
use App\TeamDetail;
use App\Team;
use Session;
class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        $title = "Staff";
        if(Auth::user()->role_id==4)
            $data = User::where('role_id','<>',4)->orderBy('id','desc')->get();
        elseif(Auth::user()->role_id==2)
            $data = User::where('department_id',Auth::user()->department_id)->orderBy('id','desc')->get();
        else
            return redirect()->action('HomeController@index');
        return view('html.staff.list',compact('data','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role_id == 1)
        {
            return view('html.error-403');
        }
        elseif(Auth::user()->role_id==2)
        {
            return redirect()->action('LeaderController@getAddMember');
        }
        $title = "Add Staff";
        $role = Role::where('id','<>','4')->get();
        $department = Department::all();
        return view('html.staff.add-edit',compact('role','title','department'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request, User $user)
    {
        //
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
        return redirect()->route('admin.staff.index')->with('success','Posted completely!');
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
        if(\Auth::user()->role_id == 1)
        {
            return view('html.error-403');
        }
        $title = "Edit ".$staff->name;
        $role = Role::where('id','<>','4')->get();
        $department = Department::all();
        return view('html.staff.add-edit',compact('staff','title','role','department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\Illuminate\Http\Request $request, User $staff){        
        $this->validate($request,
            ["sltDepartment"=>"required",'sltRole'=>'required'],
            ["sltDepartment.required"=>"Please select department.","sltRole.required"=>"Please select role."]);         
        $staff->role_id = $request->sltRole;
        $staff->department_id = $request->sltDepartment;
        $staff->level_id = $request->rdbLevel;
        $staff->active = $request->rdbStatus;
        $staff->save();
        return redirect()->route('admin.staff.index')->with('success','Edited completely!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($staff)
    {
        if(\Auth::user()->role_id == 1)
        {
            return view('html.error-403');
        }          
        if($staff->role_id == 4)
        {
            return view('html.error-403');
        }  
        $teams=Team::where('created_user_id',$staff->id)->get();
        foreach ($teams as $key => $value) {
            TeamDetail::where('team_id',$value->id)->delete();
        }
        foreach ($teams as $key => $value) {
            $value->delete();
        }        
        $detail = TeamDetail::where('staff_id',$staff->id)->get();
        foreach ($detail as $key => $value) {
            $value->delete();
        }
        Profile::where('user_id',$staff->id)->first()->delete();        
        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success','Deleted Successfully!!!');
    }
    public function getLevel($id)
    {
         $level = Level::where('role_id',$id)->get();
        return view('html.block.level',compact('level'));        
    }
    public function getCurrentLevel($code,$id)
    {   
        $user = User::find($code);
        $level = Level::where('role_id',$id)->get();
        return view('html.block.level',compact('level','user'));        
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
    public function getProfile()
    {        
        $title = "Profile's User";
        $model = User::with('profile')->where('id',Auth::user()->id)->get();
        return view('html.profile.index',compact('model','title'));
    }
    public function postProfile(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();
        $profile = Profile::where('user_id',$user->id)->first();
        // var_dump($profile->avatar); exit();
        $img_cur = 'public/assets/images/'.Auth::user()->profile->avatar;
        // var_dump(Request::input('input22')); exit();
        if(Request::file('input22')){
            $file_name = Request::file('input22')->getClientOriginalName();
            $profile->avatar = $file_name;

            Request::file('input22')->move('public/assets/images/',$file_name);
            if(File::exists($img_cur)){
                File::delete($img_cur);
            }
            
        }else{
            echo "no file";
        }
        $user->name = $request->input('txtName'); 
        $user->birthday = $request->input('txtBirth'); 
        $user->phone = $request->input('txtPhone'); 
        $user->save();
        $profile->website = $request->input('txtWebsite');
        $profile->address = changePlace($request->input('txtAddr')); 
        $profile->save();
        return redirect()->action('StaffController@getProfile')->with('success','Successfully!');        

    }
    public function clear()
    {
        if(!Request::input('checkbox'))
        {
            return redirect()->back()->with('danger','You forgot chosing items');
        }
        foreach (Request::input('checkbox') as $key => $value) {
            $staff = User::find($value);
            $teams=Team::where('created_user_id',$staff->id)->get();
            foreach ($teams as $key => $value) {
                TeamDetail::where('team_id',$value->id)->delete();
            }
            foreach ($teams as $key => $value) {
                $value->delete();
            }        
            $detail = TeamDetail::where('staff_id',$staff->id)->get();
            foreach ($detail as $key => $value) {
                $value->delete();
            }
            Profile::where('user_id',$staff->id)->first()->delete();
            $staff->delete();
                
        }
        return redirect()->route('admin.index')->with('success','successfully deleted');
    }
}

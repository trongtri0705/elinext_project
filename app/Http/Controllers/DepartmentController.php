<?php
namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Department;
use Datatables;
use App\User;
use Hash,Mail;
use App\Profile;
use App\Http\Requests\UserRequest;
use App\Team, App\TeamDetail;
use Auth;
class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        view()->share('type', 'department');
    }
    public function index()
    {
        //
        $title = "Departments";
        $data = Department::orderBy('id','desc')->get();
        return view('html.department.list',compact('data','title'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {     
        $title = "Create Department";
        return view('html.department.add-edit',compact('title'));
    }
    public function getAdd($id)
    {
        if(Auth::user()->role_id!=3)
            return view('html.error-403');
        $dep = Department::find($id);
        $title = "Add members";
        return view('html.department.add-member',compact('title','dep'));
    }
     public function postAdd(UserRequest $request)
    {
        if($request->sltRole>2)
            return redirect()->back()->with('danger','Dont try to be a hacker!!!');
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
    public function getDelMember($id)
    {
        $staff = User::find($id);
        if(\Auth::user()->role_id == 1)
        {
            return view('html.error-403');
        }          
        if($staff->role_id == 4)
        {
            return view('html.error-403');
        }  
        $teams=Team::where('created_user_id',$staff->id)->get();
        if(!empty($team))
        {
            foreach ($teams as $key => $value) {
                TeamDetail::where('team_id',$value->id)->delete();
            }
            foreach ($teams as $key => $value) {
                $value->delete();
            }   
        }             
        $detail = TeamDetail::where('staff_id',$staff->id)->get();
        if(!empty($detail))
        {
            foreach ($detail as $key => $value) {
                $value->delete();
            }
        }        
        Profile::where('user_id',$staff->id)->first()->delete();
        $staff->delete();
        return redirect()->route('admin.index')->with('success','Deleted Successfully!!!');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {
        //
        $model = new Department();
        $model->name = $request->txtName;        
        $model->save();
        return redirect()->route('admin.department.index')->with('success','Posted completely!');
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
    public function edit(Department $department)
    {
        if($department->id<7)
            return redirect()->route('admin.department.index')->with('danger','You\'d not better do this action!!!');
        $title = "Edit Department";
        return view('html.department.add-edit',compact('department','title'));
    }
    /*
     *update function
     */
    public function update(DepartmentRequest $request, Department $department){        
       
        $department->name = $request->txtName;
        $department->save();
        return redirect()->route('admin.department.index')->with('success','Edited completely!');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */    
    public function destroy(Department $department)
    {
        if($department->id<7)
            return redirect()->route('admin.department.index')->with('danger','You\'d not better do this action!!!');
        $department->delete();
        return redirect()->route('admin.department.index')->with('success','successfully deleted');
        
    }
    public function clear(Request $request)
    {
        foreach (Request::input('checkbox') as $key => $value) {
            $model = Department::find($value);
            $model->delete();
        }
        return redirect()->route('admin.department.index')->with('success','successfully deleted');
    }
}

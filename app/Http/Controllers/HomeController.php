<?php namespace App\Http\Controllers;
use App\User,Auth,Hash;
use App\Http\Requests;
use App\Department;
use Session;
use Request;
use App\Http\Requests\ChangePassRequest;
use App\Leader,App\TeamDetail;
use Mail;
use App\Team;
use App\Http\Requests\UserRequest;
use App\Profile;
use App\Review;
class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{		
		$title = "Dashboard";		
		if(Auth::user()->role_id==4)
		{
			$model = Department::with(['user','developer','leader','manager'])->get();		
			return view('html.dashboard.admin',compact('title','model'));
		}
		elseif (Auth::user()->role_id==3) {
			$department = Department::get();
			return view('html.dashboard.manager',compact('title','model','department'));
		}
		elseif (Auth::user()->role_id==2) {
			$list = Department::find(Auth::user()->department_id);
			return view('html.dashboard.leader',compact('title','list'));
		}
		else 
		{			
			// if(Auth::user()->teamdetail)
			// {
			// 	$sum=0;
			// 	foreach (Auth::user()->teamdetail as $key => $value) 		
			// 	{
			// 		foreach ($value->team->detail as $key => $item)
			// 		{
			// 			// var_dump(count($value->team->detail));
			// 			foreach ($item->account->review as $key => $review) {
			// 				# code...
			// 				$sum+=($review->point);
			// 			}

			// 		}
			// 		var_dump($sum);
			// 	}
			// 	exit();
			// }				
			return view('html.dashboard.developer',compact('title'));
		}
		// // $leader = User::find($team->created_user_id);
	}// $bol = "true";
						// $list = TeamDetail::select('*')->where('team_id',$var->team_id)->get();				
						// foreach ($list as $key => $item) {
			   //              if($item->score)
			   //                  foreach($item->score as $score)
			   //                  {
			   //                      if(date('m',strtotime($score->created_at))==date("m"))
			   //                          $sum += $score->point;
			   //                  }                
			   //          }
			   //          var_dump($sum);exit();
			   //          $avg = $sum/count($list);
	public function getChangePassword()
	{
		$id = Auth::user()->id;
		$model = User::find($id);
		$title = "Change Password";
		return view('html.changepassword',compact('model','title'));

	}
	public function postChangePassword(ChangePassRequest $request)
	{	
		
		if(!Hash::check($request->txtOldPass,Auth::user()->password))
			return redirect()->back()->withErrors(['Wrong Password']);
		else{
			$user = Auth::user();
        	$pass = $request->txtPass;
            $user->password = Hash::make($pass);
            $user->remember_token = Request::input('_token');
	        $user->save();
			return redirect()->intended()->with('success','Finished');                       
       } 
	}
	public function getCreateManager()
	{
		if(\Auth::user()->role_id !=4)
        {
            return view('html.error-403');
        }
		$title = "Managers";
		$developer = User::where('role_id','<',3)->get();
		return view('html.team.admin.create-manager',compact('title','developer'));
	}
	public function getCreateLeader()
	{
		if(\Auth::user()->role_id < 3)
        {
            return view('html.error-403');
        }
		$title = "Leaders";
		$developer = User::where('role_id',1)->get();
		return view('html.team.admin.create-leader',compact('title','developer'));
	}
	public function postCreateManager(\Illuminate\Http\Request $request)
	{
		$this->validate($request,
            ['staff'=>'required'],
            ['staff.required'=>'Please select staff']);
		foreach (Request::input('staff') as $key => $value)
        {
            $user = User::find($value);
            $user->role_id = 3;
            $user->save();
        }
        return redirect()->route('admin.team.manager.index')->with('success','Added completely!');
	}
	public function postCreateLeader(\Illuminate\Http\Request $request)
	{
		$this->validate($request,
            ['staff'=>'required'],
            ['staff.required'=>'Please select staff']);
		foreach (Request::input('staff') as $key => $value)
        {
            $user = User::find($value);
            $user->role_id = 2;
            $user->save();
        }
        return redirect()->route('admin.team.leader.index')->with('success','Added completely!');
	}
	public function getCreateNewLeader()
	{
		$department = Department::all();
		$title = "Create A New Leader";
		return view('html.team.admin.create-new-leader',compact('title','department'));
	}
	 public function postCreateNewLeader(UserRequest $request)
    {
        if($request->sltRole!=2)
            return redirect()->back()->with('danger','Dont change role,please!');
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
    public function getCreateNewManager()
	{
		$department = Department::all();
		$title = "Create A New Manager";
		return view('html.team.admin.create-new-manager',compact('title','department'));
	}
	 public function postCreateNewManager(UserRequest $request)
    {
        if($request->sltRole!=3)
            return redirect()->back()->with('danger','Dont change role,please!');
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
                'name'   	=> Request::input('txtName'),
                'password' 	=> Request::input('txtPass'),
                'email'		=> Request::input('txtEmail')
                ];
            Mail::send('emails.blanks',$data,function($message){
                $message->from('trongtri0705@gmail.com','Nguyen Trong Tri');
                $message->to(Request::input('txtEmail'),Request::input('txtName'))->subject('This is mail');
            });
        }        
        return redirect()->route('admin.index')->with('success','Added completely!');
    }
    public function getHelp()
    {
    	$title = "Help";
    	if(Auth::user()->role_id==4)
    		return view('html.help.admin',compact('title'));
    	elseif(Auth::user()->role_id==3)
    		return view('html.help.manager',compact('title'));
    	elseif(Auth::user()->role_id==2)
    		return view('html.help.leader',compact('title'));
    	else
    		return view('html.help.developer',compact('title'));
    }
	
}

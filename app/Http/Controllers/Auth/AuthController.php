<?php namespace App\Http\Controllers\Auth;
use App\User;
use App\Staff;
use DB,Hash;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Validator;
use App\Http\Requests\StaffRequest;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\ThrottlesLogins;
class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers,ThrottlesLogins;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	
	public function __construct(Guard $auth, PasswordBroker $passwords)
	{
		$this->auth = $auth;
		$this->passwords = $passwords;

		$this->middleware('guest');
		$this->middleware('guest', ['except' => 'getLogout']);
	}
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
		]);
	}
	
	// public function getLogin()
	// {
	// 	 if (view()->exists('auth.authenticate')) {
 //           return view('auth.authenticate');
 //       }
	// 	return view('html.login');
	// }
	// public function postLogin(StaffRequest $request)
	// {
	// 	// $login = array(
	// 	// 	'email' => $request->email,
	// 	// 	'password'=>$request->password,
	// 	// 	'level'=>1,
	// 	// );
	// 	// if($this->auth->attempt($login)){
	// 	// 	return redirect()->route('admin.product.list');
	// 	// }
	// 	// else
	// 	// 	return redirect()->back();
	// 	$email = $request->email;
	// 	$user = DB::table('staff')->where(['email'=>$email,'active'=>1])->first();
	// 	if(!$user)
	// 		return redirect()->back();
	// 	else
	// 	{
	// 		$password = $request->password;	
	// 		// $pw = DB::table('system_admin')->where('staff_id',$user['id'])->first();
	// 		if($this->auth->attempt(['staff_id'   => $user->id,
	// 								 'password'=>$request->password,
	// 								 'active'   =>1]))
	// 			return redirect()->route('admin.department.index');
	// 		else
	// 			return redirect()->back()->with('success',Hash::make($password));
	// 	}
	// }
	// public function getLogout()
	// {
	// 	auth()->logout();
	// 	return redirect('auth/login');
	// }

}

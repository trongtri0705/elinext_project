<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/',function(){
	return redirect()->route('admin.index');
});
Route::get('home',function(){
	return redirect()->route('admin.index');
});
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::model('department', 'App\Department');
Route::model('staff', 'App\User');
Route::model('level', 'App\Level');
Route::model('manager', 'App\Manager');
Route::model('leader', 'App\Leader');
Route::model('review','App\Review');
Route::filter('auth', function()
{
	if (Auth::guest())
    {
        if (Request::ajax())
        {
            return Response::make('Unauthorized', 401);
        }
        else
        {
            return Redirect::guest('auth/login');
        }
	}
	else
	{
	    if(Auth::check() && !Auth::user()->active)
	    {
	        Auth::logout();        
	        return Redirect::to('auth/login')->with('danger','Your account is banned, please contact your administrator to active your account');
	    }
	}
});
Route::group(['prefix'=>'admin','before'=>'auth'],function(){			
	Route::get('index',['as'=>'admin.index','uses'=>'HomeController@index']);			
	Route::group(['prefix'=>'team'],function(){
		Route::resource('manager','ManagerController');
		Route::get('manager/delete/{id}','ManagerController@delete');
		Route::get('manager/add/{id}','ManagerController@getAdd');
		Route::post('manager/add/{id}','ManagerController@postAdd');
		Route::get('manager/{id}/{user}/delete','ManagerController@destroy');
		Route::resource('leader','LeaderController');	
		Route::get('leader/delete/{id}','LeaderController@delete');
		Route::get('leader/add/{id}','LeaderController@getAdd');		
		Route::post('leader/add/{id}','LeaderController@postAdd');
		Route::get('leader/{id}/{user}/delete','LeaderController@destroy');
	});	
	Route::get('review','ReviewController@index');
	Route::get('review/create/{id}','ReviewController@getReview');
	Route::post('review/create/{id}','ReviewController@postReview');
	Route::post('review/content','ReviewController@store');
	Route::get('review/{id}','ReviewController@show');
	Route::resource('team','TeamController');
	Route::get('team/delete/{id}','TeamController@delete');
	Route::post('team/clear','TeamController@clear');
	Route::get('profile','StaffController@getProfile');	
	Route::post('profile','StaffController@postProfile');
	Route::get('changepassword','HomeController@getChangePassword');	
	Route::post('changepassword','HomeController@postChangePassword');	
	Route::resource('department', 'DepartmentController');
	Route::get('department/add/{id}','DepartmentController@getAdd');
	Route::post('department/add/{id}','DepartmentController@postAdd');
	Route::get('department/{id}/delmember','DepartmentController@getDelMember');	
	Route::resource('level', 'LevelController');
	Route::get('level/{level}/delete','LevelController@destroy');		
	Route::post('level/clear','LevelController@clear');			
	Route::get('department/{department}/delete','DepartmentController@destroy');		
	Route::post('department/clear','DepartmentController@clear');			
	Route::resource('staff', 'StaffController');
	Route::get('staff/{staff}/delete','StaffController@destroy');		
	Route::get('staff/getcurrentlevel/{code}/{id}','StaffController@getCurrentLevel');
	Route::get('staff/getlevel/{id}','StaffController@getLevel');
	Route::post('staff/clear','StaffController@clear');
	Route::get('leader/addmember','LeaderController@getAddMember');
	Route::post('leader/addmember','LeaderController@postAddMember');
	Route::get('create-manager','HomeController@getCreateManager');	
	Route::post('create-manager','HomeController@postCreateManager');
	Route::get('create-new-manager','HomeController@getCreateNewManager');
	Route::post('create-new-manager','HomeController@postCreateNewManager');
	Route::get('create-leader','HomeController@getCreateLeader');
	Route::post('create-leader','HomeController@postCreateLeader');
	Route::get('create-new-leader','HomeController@getCreateNewLeader');
	Route::post('create-new-leader','HomeController@postCreateNewLeader');
	Route::get('help','HomeController@getHelp');
});


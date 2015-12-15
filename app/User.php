<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'staff';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name','phone','email'];
	protected $hidden = ['password'];
	public $timestamps = false;
	public function profile()
	{
		return $this->hasOne('App\Profile');
	}		
	public function review()
	{
		return $this->hasMany('App\Review','staff_id')->orderBy('created_at','desc')->limit(2);
	}
	public function score()
	{
		return $this->hasMany('App\Review','staff_id');
	}
	public function role()
	{
		return $this->belongsTo('App\Role');
	}
	public function level()
	{
		return $this->belongsTo('App\Level');
	}
	public function department()
	{
		return $this->belongsTo('App\Department');
	}
	public function teamdetail()
	{
		return $this->hasMany('App\TeamDetail','staff_id');
	}
}

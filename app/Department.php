<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model {

	//
	protected $table = 'department';
	protected $fillable = ['name'];
	public $timestamps = false;
	public function user(){
		return $this->hasMany(User::class,'department_id');
	}
	public function developer(){
		return $this->hasMany(User::class,'department_id')->where('role_id','1');
	}
	public function leader(){
		return $this->hasMany(User::class,'department_id')->where('role_id','2');
	}
	public function manager(){
		return $this->hasMany(User::class,'department_id')->where('role_id','3');
	}
}

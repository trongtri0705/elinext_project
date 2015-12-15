<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model{

	//
	public $timestamps = false;
	public $owners = false;
	public $alias = false;
	protected $table = 'roles';
	protected $fillable = ['name','alias'];
	function level()
	{
		return $this->hasMany('App\Level');
	}

}

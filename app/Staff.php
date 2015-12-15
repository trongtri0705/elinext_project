<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model {

	//
	protected $table = 'staff';
	protected $fillable = ['name','phone','email'];
	// public $timestamps = false;
	

}

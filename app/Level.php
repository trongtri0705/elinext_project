<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model {

	//
	protected $table = 'levels';
	protected $fillable = ['name','rold_id'];
	public $timestamps = false;
	public function role(){
		return $this->belongsTo('App\Role');
	}

}

<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Leader extends Model {

	//
	protected $table = 'teams';
	protected $fillable = ['name','created_user_id','email'];
	public $timestamps = false;
	public function detail()
	{
		return $this->hasMany(TeamDetail::class,'team_id');
	}
}

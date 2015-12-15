<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamDetail extends Model
{
    //
    protected $table = 'team_detail';
    	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['team_id','staff_id'];	
	public function account()
	{
		return $this->belongsTo('App\User','staff_id');
	}
	public function team()
	{
		return $this->belongsTo('App\Team');
	}
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $table = 'reviews';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['staff_id','reviewer_id','point','comment','active'];
	protected $hidden = ['password'];	
	public function user()
	{
		return $this->belongsTo('App\User','staff_id');
	}
	public function creater()
	{
		return $this->belongsTo('App\User','reviewer_id');
	}
}

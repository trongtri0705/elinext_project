<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

	//
	protected $table = 'products';
	protected $fillable = ['name','order','alias','price','intro','image','content','keywords','description','user_id','cate_id'];
	// public $timestamps = true;
	public function cate(){
		return $this->belongTo('App\Cate');
	}
	public function user(){
		return $this->belongTo('App\User');
	}
	public function pimages(){
		return $this->hasMany('App\ProductImage');
	}
}

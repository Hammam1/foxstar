<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
	protected $fillable = ['name','category', 'directed_by', 'championship', 'in_conjunction_with','image','author'];
	
	public function rings()
    {
        return $this->hasMany('App\Ring','categories_id');
    }
	public function user()
    {
        return $this->belongsTo('App\User');
    }
	
}

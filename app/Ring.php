<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ring extends Model
{
    //
	protected $fillable = ['name', 'image', 'link'];
	
	public function category()
    {
        return $this->belongsTo('App\Category','categories_id');
    }
	public function user()
    {
        return $this->belongsTo('App\User');
    }
	
}

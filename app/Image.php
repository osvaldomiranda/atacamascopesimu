<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['path'];

    public function urlPath(){
    	return \Storage::url($this->path); 
    }
    public function user()
	{
	   	return $this->belongsTo(User::class);
	}
    public function equipment()
	{
	   	return $this->belongsTo(Equipment::class);
	}
}

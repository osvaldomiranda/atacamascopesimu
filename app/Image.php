<?php

namespace App;
use File;
use App\Command;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['path'];

    public function url(){
    	
    	$filename = substr($this->path,7,100);

	    $path = storage_path('app/public/' . $filename);

	    if (!File::exists($path)) {
	        return '';
	    }

	    $path = 'http://10.200.112.245/storage/' . $filename;
 
	    return $path;  	
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

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    public function user()
	{
	   	return $this->belongsTo(User::class);
	}
    public function equipment()
	{
	   	return $this->belongsTo(Equipment::class);
	}
}

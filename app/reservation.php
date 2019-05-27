<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Equipment;

class reservation extends Model
{
    public function equipment()
	{
	   	return $this->belongsTo(Equipment::class, 'equipment_id');
	}
}

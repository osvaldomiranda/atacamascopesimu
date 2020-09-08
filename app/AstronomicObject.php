<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TipeObject;

class AstronomicObject extends Model
{

    protected $fillable = [ 'name','catalog','type_object','ra','dec','constellation','bmag',
                            'hubble','coord_ar','coord_dec','sign_dec','colloquial_name',
                            'equivalence' ];


	public function scopeType($query, $type)
    {
    	
        if (!is_null($type)) {
            Info($type);
            return $query->where('type_object',$type);     
        }
        return $query;
    }
	public function scopeConstellation($query, $constellation)
    {
    	
        if (!is_null($constellation)) {
            Info($constellation);
            return $query->where('constellation','ILIKE', '%'.$constellation.'%');     
        }
        return $query;
    }

	public function scopeName($query, $name)
    {
    	Info($name);
        if (!is_null($name)) {
            Info($name);
            return $query->where('name', 'ILIKE', '%'.$name.'%')->whereOr('colloquial_name','ILIKE', '%'.$name.'%')->whereOr('nombre_coloquial','ILIKE', '%'.$name.'%');     
        }
        return $query;
    }

}

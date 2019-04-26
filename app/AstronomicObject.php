<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TipeObject;

class AstronomicObject extends Model
{

    protected $fillable = [ 'name','catalog','type_object','ra','dec','constellation','bmag',
                            'hubble','coord_ar','coord_dec','sign_dec','colloquial_name',
                            'equivalence' ];



}

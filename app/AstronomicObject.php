<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TipeObject;

class AstronomicObject extends Model
{

	protected $fillable = [ 'name','catalog','type_object','ra','dec','constellation','bmag',
							'hubble','coord_ar','coord_dec','sign_dec','colloquial_name',
							'equivalence' ];



  // def convert_coord
  //   ar = self.ra
  //   dec = self.dec

  //   if self.catalog=='MESSIER'
  //     h_ar = ar.split[0].to_f
  //     m_ar = ar.split[1].to_f
      
  //     sign = dec[0..0]
  //     h_dec = dec[1..2].to_f
  //     m_dec = dec[5..6].to_f
      
  //     coord_ar = h_ar + (m_ar/60) 
  //     coord_dec = h_dec + (m_dec/60) 
  //   else
  //     h_ar = ar[2..3].to_f
  //     m_ar = ar[5..6].to_f
  //     s_ar = ar[8..15].to_f

  //     sign = dec[0..0]
  //     h_dec = dec[1..2].to_f
  //     m_dec = dec[4..5].to_f
  //     s_dec = dec[7..20].to_f

  //     coord_ar = h_ar + (m_ar/60) + (s_ar/3600)
  //     coord_dec = h_dec + (m_dec/60) + (s_dec/3600)
  //   end  

  //   self.coord_dec = coord_dec
  //   self.coord_ar = coord_ar
  //   self.sign_dec = sign

  //   self.save    
  // end  

}

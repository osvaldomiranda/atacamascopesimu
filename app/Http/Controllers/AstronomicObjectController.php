<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AstronomicObject;

class AstronomicObjectController extends Controller
{
    public function index()
    {
    	$astronomicObjects = AstronomicObject::all()->toArray();
    	return response()->json($astronomicObjects);
    }

    public function solarSistem(Request $request){
    	$object = $request->input('object');
    	$date = date("Y/m/d");
    	$time = date("H:i:s");



    	$coord= exec("python planeta.py -o " . $object . " -d " . $date . "t" . $time);
    	
    	
    	$ra = preg_split("/ /",$coord)[0];
      	$dec = preg_split("/ /",$coord)[1];

       	$h_ra = (float)preg_split("/:/",$ra)[0];   
       	$m_ra = (float)preg_split("/:/",$ra)[1]; 
       	$s_ra = (float)preg_split("/:/",$ra)[2]; 

       	$h_dec = (float)preg_split("/:/",$dec)[0];
       	$m_dec = (float)preg_split("/:/",$dec)[1];
       	$s_dec = (float)preg_split("/:/",$dec)[2];

	    if($h_dec < 0.0){
	    	$sign = '-';
	    	$h_dec = $h_dec * -1;
	    } else {
	    	$sign = '+';  
	    }

	    $ac_selected  = ($h_ra + ($m_ra/60) + ($s_ra/3600));
	    $dec_selected = ($sign . ($h_dec + ($m_dec/60) + ($s_dec/3600)));

	    $coord = ['ar'=>(string)$ac_selected, 'dec'=>$dec_selected];

	    return response()->json($coord);	
    }

    public function coords()
    {        
        $objects = AstronomicObject::all();

        foreach ($objects as $object) {       
            $ra = $object->ra;
            $dec = $object->dec;
            $name = $object->name;

            $cat = substr($name,0,1);

            if($cat == 'I'){
            	$object->catalog = 'IC';
            }
            if($cat == 'N'){
            	$object->catalog = 'NGC';
            }
            if($cat == 'M'){
            	$object->catalog = 'Messier';
            }
            if($cat == 'S'){
            	$object->catalog = 'SolarSistem';
            }

            $object->save();

            Info($object);


         //    if($ra){
         //    	Info($ra);
         //    	Info($dec);


	        //     $h_ra = (float)preg_split("/:/",$ra)[0];   
	        //     $m_ra = (float)preg_split("/:/",$ra)[1]; 
	        //     $s_ra = (float)preg_split("/:/",$ra)[2]; 

	        //     $h_dec = (float)preg_split("/:/",$dec)[0];
	        //     $m_dec = (float)preg_split("/:/",$dec)[1];

	        //     if( count(preg_split("/:/",$dec)) > 2 ){
	        //     	$s_dec = (float)preg_split("/:/",$dec)[2];
	        // 	} else {
	        // 		$s_dec = 0;
	        // 	}


	        //     if($h_dec < 0.0){
	        //         $sign = '-';
	        //         $h_dec = $h_dec * -1;
	        //     } else {
	        //         $sign = '+';  
	        //     }

	        //     $ac_selected  = ($h_ra + ($m_ra/60) + ($s_ra/3600));
	        //     $dec_selected = ($h_dec + ($m_dec/60) + ($s_dec/3600));

	        //     $object->coord_ar = $ac_selected;
	        //     $object->coord_dec = $dec_selected;
	        //     $object->sign_dec = $sign;
	        //     $object->save();

	        //     Info($object);
        	// }
        }

        return response()->json('OK');
    }

}

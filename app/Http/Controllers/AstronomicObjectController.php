<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AstronomicObject;

class AstronomicObjectController extends Controller
{
    public function index(Request $request)
    {

       

        $astronomicObjects = AstronomicObject::where('catalog','SolarSistem')->get()->toArray();

        // $catalog = $request->input('catalog');

        // if($catalog){
    	   // $astronomicObjects = AstronomicObject::where('catalog',$catalog)->get()->toArray();
        // }

        $constellation = $request->input('constellation');
        $type = $request->input('type');

        if($constellation=='undefined'){
            $constellation=null;
        }

        Info($constellation);
        Info($type);

        if($type and !$constellation){
            Info("tipo y ! const");
            $astronomicObjects = AstronomicObject::where('type_object',$type)->get()->toArray();
        }

        if(!$type and $constellation){
            Info("!tipo y const");
            $astronomicObjects = AstronomicObject::where('constellation',$constellation)->get()->toArray();
        }

        if($type and $constellation){
            Info("tipo y const");
            $astronomicObjects = AstronomicObject::where('constellation',$constellation)->where('type_object',$type)->get()->toArray();
        }


    	return response()->json($astronomicObjects);
    }







    public function solarSistem(Request $request){
    	$object = $request->input('object');

    	$date = date("Y/m/d");
    	$time = date("H:i:s");

    	$coord= shell_exec("python planeta.py -o " . $object . " -d " . $date . "t" . $time);    	
    	
        $coord = str_replace("(","",$coord);
        $coord = str_replace(")","",$coord);
        $coord = str_replace(",","",$coord);

    	$ra = preg_split("/ /",$coord)[0];
      	$dec = preg_split("/ /",$coord)[1];

       	$h_ra = (float)preg_split("/:/",$ra)[0];   
       	$m_ra = (float)preg_split("/:/",$ra)[1]; 
       	$s_ra = (float)preg_split("/:/",$ra)[2]; 

       	$h_dec = (float)preg_split("/:/",$dec)[0];
       	$m_dec = (float)preg_split("/:/",$dec)[1];
       	$s_dec = (float)preg_split("/:/",$dec)[2];


	    $ac_selected  = $h_ra . 'h' . $m_ra . 'm' . $s_ra . 's';
	    $dec_selected = $h_dec . '°' . $m_dec . 'm' . $s_dec . 's' ;

	    $coord = ['ar'=>(string)$ac_selected, 'dec'=>$dec_selected];

	    return response()->json($coord);	
    }

    public function moon(Request $request){

       // Info($request->header());
        $date_param = $request->header('moondate');
       // Info("date parap" . $date_param);

        $date = str_replace("-","/",$date_param);

        $time = "00:00:00";

        Info($date . "t" . $time);

        $coord= shell_exec("python moon.py -d " . $date . "t" . $time); 

        Info($coord);

        return response()->json($coord);
    }





    // public function coords()
    // {        
    //     $objects = AstronomicObject::all();

    //     foreach ($objects as $object) {       
    //         $ra = $object->ra;
    //         $dec = $object->dec;
    //         $name = $object->name;


    //         //************************
    //         //************************
    //         // nombre catalogo

    //         $cat = substr($name,0,1);

    //         if($cat == 'I'){
    //         	$object->catalog = 'IC';
    //         }
    //         if($cat == 'N'){
    //         	$object->catalog = 'NGC';
    //         }
    //         if($cat == 'M'){
    //         	$object->catalog = 'Messier';
    //         }
  

    //         $object->save();

    //         Info($object);


    //         //***************************
    //         //***************************
    //         // Coordenadas no mesier

    //         if($ra){
    //         	Info($ra);
    //         	Info($dec);

    //             if($cat != 'M'){

	   //          $h_ra = (float)preg_split("/:/",$ra)[0];   
	   //          $m_ra = (float)preg_split("/:/",$ra)[1]; 
	   //          $s_ra = (float)preg_split("/:/",$ra)[2]; 

	   //          $h_dec = (float)preg_split("/:/",$dec)[0];
	   //          $m_dec = (float)preg_split("/:/",$dec)[1];

	   //          if( count(preg_split("/:/",$dec)) > 2 ){
	   //          	$s_dec = (float)preg_split("/:/",$dec)[2];
	   //      	} else {
	   //      		$s_dec = 0;
	   //      	}


	   //          if($h_dec < 0.0){
	   //              $sign = '-';
	   //              $h_dec = $h_dec * -1;
	   //          } else {
	   //              $sign = '+';  
	   //          }

	   //          $ac_selected  = ($h_ra + ($m_ra/60) + ($s_ra/3600));
	   //          $dec_selected = ($h_dec + ($m_dec/60) + ($s_dec/3600));

	   //          $object->coord_ar = $ac_selected;
	   //          $object->coord_dec = $dec_selected;
	   //          $object->sign_dec = $sign;
	   //          $object->save();

    //             }

	   //          Info($object);
    //     	}

    //         //***************************
    //         //***************************
    //         // Coordenadas Messier
    //         if($ra){
    //         	if($cat == 'M' ){
	   //          	Info($ra);
	   //          	Info($dec);


		  //           $h_ra = (float) substr(preg_split("/ /",$ra)[0],0, strpos(preg_split("/ /",$ra)[0],'h'));  
		  //           $m_ra = (float) substr(preg_split("/ /",$ra)[0],0, strpos(preg_split("/ /",$ra)[1],'m')); 
		           

		  //           $h_dec = (float)substr(preg_split("/ /",$dec)[0],0,3);
		  //           $m_dec = (float)substr(preg_split("/ /",$dec)[1],0,2);



		  //           if($h_dec < 0.0){
		  //               $sign = '-';
		  //               $h_dec = $h_dec * -1;
		  //           } else {
		  //               $sign = '+';  
		  //           }

		  //           $ac_selected  = ($h_ra + ($m_ra/60) );
		  //           $dec_selected = ($h_dec + ($m_dec/60) );

		  //           $object->coord_ar = $ac_selected;
		  //           $object->coord_dec = $dec_selected;
		  //           $object->sign_dec = $sign;
		  //           $object->save();

		  //           Info($object);
		  //       }   
    //     	}


    //     }

    //     return response()->json('OK');
    // }

}

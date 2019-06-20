<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publication;
use Carbon\Carbon;

class PublicationController extends Controller
{
    public function publications(Request $request)
    {
        $publications = Publication::where('type','PUBLICATION')->where('fini', '<=', Carbon::now())->where('ffin', '>=', Carbon::now())->get();
        return response()->json($publications);
    }
    public function offers(Request $request)
    {
        $publications = Publication::where('type','OFFER')->where('fini', '<=', Carbon::now())->where('ffin', '>=', Carbon::now())->get();
        return response()->json($publications);
    }
}

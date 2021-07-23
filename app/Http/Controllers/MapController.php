<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function mapIndex(Request $request)
    {
        
        return view('map.index');
    }
}

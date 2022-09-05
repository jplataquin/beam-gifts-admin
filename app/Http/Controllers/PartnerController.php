<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function create(){
        return view('brand/create');
    }

    public function _create(Request $request){
        
    }
}

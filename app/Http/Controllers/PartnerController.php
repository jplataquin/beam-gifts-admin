<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Partner;

class PartnerController extends Controller
{
    public function create(){
        return view('partner/create');
    }

    public function _create(Request $request){
        
        //TODO Validation

        $brand_id       = (int) $request->input('brand');
        $branch         = $request->input('branch');
        $email          = $request->input('email');
        $uername        = $request->input('username');

        $primary_contact_person             = $request->input('primary_contact_person');
        $primary_contact_no                 = $request->input('primary_contact_no');
        $primary_contact_person_position    = $request->input('primary_contact_person_position');
        
        $secondary_contact_person           = $request->input('secondary_contact_person');
        $secondary_contact_no               = $request->input('secondary_contact_no');
        $secondary_contact_person_position  = $request->input('secondary_contact_person_position');
        
        $partner = new Partner();

        $partner->password  = Hash::make('12345678');
        $partner->email     = $email;
        $partner->brand_id  = $brand_id;

        $partner->primary_contact_person            = $primary_contact_person;
        $partner->primary_contact_no                = $primary_contact_no;
        $partner->primary_contact_person_position   = $primary_contact_person_position;

        $partner->secondary_contact_person            = $secondary_contact_person;
        $partner->secondary_contact_no                = $secondary_contact_no;
        $partner->secondary_contact_person_position   = $secondary_contact_person_position;

        $partner->name = $username;

        $partner->save();

        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> [
                'id' => $partner->id
            ]
        ]);
    }
}

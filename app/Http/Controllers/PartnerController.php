<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Partner;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;

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
        $username        = $request->input('username');
        $status         = $request->input('status');

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
        $partner->branch    = $branch;
        $partner->status    = $status;

        $partner->primary_contact_person            = $primary_contact_person;
        $partner->primary_contact_no                = $primary_contact_no;
        $partner->primary_contact_person_position   = $primary_contact_person_position;

        $partner->secondary_contact_person            = $secondary_contact_person;
        $partner->secondary_contact_no                = $secondary_contact_no;
        $partner->secondary_contact_person_position   = $secondary_contact_person_position;

        $partner->name          = $username;
        $partner->created_by    = Auth::id();

        $partner->save();

        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> [
                'id' => $partner->id
            ]
        ]);
    }


    public function list(){
        return view('partner/list',[]);
    }

    public function _list(Request $request){
        
        $query = $request->input('query') ?? '';
        $page  = (int) $request->input('page') ?? 0;
        $limit = (int) $request->Input('limit') ?? 0;

        $partner = new Partner();

        if($query){
            $partner = $partner->where('name','LIKE','%'.$query.'%');
        }
        
        if($limit > 0){
            
            $page    = $page * $limit;
            $partner = $partner->skip($page)->take($limit)->orderBy('created_at', 'desc');
            
        }else{
            $partner = $partner->orderBy('created_at', 'desc');
        }

        $result = $partner->get();
        
        
        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> $result
        ]);
    }

    public function display($id){

        $partner = Partner::findOrFail($id);

        $partner->brand = Brand::findOrFail($partner->brand)
    }
}

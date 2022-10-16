<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Brand;

class BrandController extends Controller
{
    public function create(){
        return view('brand/create');
    }

    public function _create(Request $request){
        
        //TODO VALIDATION

        $name        = $request->input('name');
        $status      = $request->input('status');
        $description = $request->input('description');
        $branches    = $request->input('branches');

        $b1 = $request->file('banner')->store('public/photos/brand/banner');
        $p1 = $request->file('400px')->store('public/photos/brand/400px');
        $p2 = $request->file('300px')->store('public/photos/brand/300px');
        $p3 = $request->file('200px')->store('public/photos/brand/200px');
        $p4 = $request->file('150px')->store('public/photos/brand/150px');

        $brand = new Brand();

        $brand->name        = $name;
        $brand->status      = $status;
        $brand->description = $description;
        $brand->branches    = $branches;
        $brand->photo = json_encode([
            'banner'    => basename($b1), 
            '400px'     => basename($p1),
            '300px'     => basename($p2),
            '200px'     => basename($p3),
            '150px'     => basename($p4)
        ]);
        
        $brand->created_by = Auth::id(); 

        $brand->save();

        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> [
                'id' => $brand->id
            ]
        ]);
    }

    public function display($id){

        $brand = new Brand();

        $brand = $brand::findOrFail($id);

        $brand->photo    = json_decode($brand->photo,true);
        $brand->branches = json_decode($brand->branches);

        return view('brand/display',$brand);
    }

    public function list(){
        return view('brand/list');
    }

    public function _list(Request $request){

        $query          = $request->input('query');
        $status         = $request->input('status');
        $page           = (int) $request->input('page') ?? 0;
        $limit          = (int) $request->input('limit') ?? 0;

        $brand = new Brand();

        if($query){
            $brand = $brand->where('name','LIKE','%'.$query.'%');
        }
        
        if($status){

            json_decode($status);

            if(json_last_error() === JSON_ERROR_NONE){
             
                $in = json_decode($status,true);

                $brand = $brand->whereIn('status',$in);
            }else{
                $brand = $brand->where('status','=',$status);
            }
            
        }

        if($limit > 0){
            $page   = $page * $limit;
            $result = $brand->skip($page)->take($limit)->orderBy('created_at', 'desc')->get();
        }else{
            $result = $brand->orderBy('created_at', 'desc')->get();
        }
        

        for($i = 0; $i <= count($result) - 1; $i++){
            $result[$i]->photo = json_decode($result[$i]->photo);
            $result[$i]->branches = json_decode($result[$i]->branches);
        }
        
        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> $result
        ]);

    }

    public function _edit(Request $request, $id){
        
        $brand = new Brand();
        $brand = $brand::find($id);
        
        if(!$brand){

            return response()->json([
                'status' => 0,
                'message'=>'Record not found',
                'data'=> []
            ]);
        }

        $name           = $request->input('name');
        $status         = $request->input('status');
        $description    = $request->input('description');
        $branches       = $request->input('branches');
        
        $photos     = json_decode($brand->photo,true);
        $branches   = json_decode($branches);

        foreach($branches as $i => $branch){
            
            if(trim($branch->name) == '' && trim($branch->address) == '' && trim($branch->phone) == ''){
                array_splice($branches, $i, 1);
            }
        }

        $dbanner = $photo['banner'] ?? '';
        $d1      = $photos['400px'] ?? '';
        $d2      = $photos['300px'] ?? '';
        $d3      = $photos['200px'] ?? '';
        $d4      = $photos['150px'] ?? '';
        
        $b1 = $request->file('banner')->store('public/photos/brand/banner');
        $p1 = $request->file('400px')->store('public/photos/brand/400px');
        $p2 = $request->file('300px')->store('public/photos/brand/300px');
        $p3 = $request->file('200px')->store('public/photos/brand/200px');
        $p4 = $request->file('150px')->store('public/photos/brand/150px');

        $brand->name         = $name;
        $brand->status       = $status;
        $brand->description  = $description;
        $brand->branches     = json_encode($branches);
        $brand->photo        = json_encode([
            'banner' => basename($b1), 
            '400px'  => basename($p1),
            '300px'  => basename($p2),
            '200px'  => basename($p3),
            '150px'  => basename($p4)
        ]);

        $brand->modified_by = Auth::id(); 

        $brand->save();

        Storage::disk('public')->delete('/photos/brand/banner/'.$dbanner);
        Storage::disk('public')->delete('/photos/brand/400px/'.$d1);
        Storage::disk('public')->delete('/photos/brand/300px/'.$d2);
        Storage::disk('public')->delete('/photos/brand/200px/'.$d3);
        Storage::disk('public')->delete('/photos/brand/150px/'.$d4);

        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> [
                'id' => $brand->id
            ]
        ]);
    }
}

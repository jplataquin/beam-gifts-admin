<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\EventTag;

class ItemController extends Controller
{
    public function __construct()
    {

    }

    public function create(){
        return view('item/create');
    }

    public function _create(Request $request){
        
        $name           = $request->input('name');
        $status         = $request->input('status');
        $description    = $request->input('description');
        $price          = $request->input('price');
        $expiry         = $request->input('expiry');
        $category       = $request->input('category');
        $brand          = $request->input('brand');
        $type           = $request->input('type');
        $eventTags      = $request->input('eventTags');
        
        $eventTags = json_decode($eventTags);

        $p1 = $request->file('400px')->store('public/photos/item/400px');
        $p2 = $request->file('300px')->store('public/photos/item/300px');
        $p3 = $request->file('200px')->store('public/photos/item/200px');
        $p4 = $request->file('150px')->store('public/photos/item/150px');

        $item = new Item();

        $item->name         = $name;
        $item->status       = $status;
        $item->description  = $description;
        $item->price        = $price;
        $item->expiry       = $expiry;
        $item->category     = $category;
        $item->brand_id     = $brand;
        $item->type         = $type;
        $item->photo        = json_encode([
            '400px' => basename($p1),
            '300px' => basename($p2),
            '200px' => basename($p3),
            '150px' => basename($p4)
        ]);

        $item->created_by = Auth::id(); 

        $item->save();

        
        if(count($eventTags)){

            $eventTag = new EventTag();
            $data = [];
            $eventOpt   = config('eventtag')['options'];
            foreach($eventTags as $tag){

                $data[] = [
                    'item_id'   => $item->id,
                    'brand_id'  => $brand,
                    'event'     => $tag,
                    'name'      => $eventOpt[$tag] ?? ''
                ];
            }
            
            $eventTag::insert($data);
        }

        
        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> [
                'id' => $item->id
            ]
        ]);
    }

    public function display($id){

        $item     = new Item();
        $eventTag = new EventTag();

        $item = $item::findOrFail($id);

        $item->photo = json_decode($item->photo,true);

        $tags = $eventTag::where('item_id','=',$id)->get(); 

        $eventTagsData = [];

        if($tags){
        
            $eventOpt = config('eventtag')['options'];

            foreach($tags as $t){

                if( isset( $eventOpt[ $t->event ] ) ){
                   
                    $eventTagsData[] = [
                        'event' => $t->event,
                        'name' => $eventOpt[ $t->event ]
                    ];
                }
            }
        }

        $item->eventTags = $eventTagsData;
      
        return view('item/display',$item);
    }

    public function list(){
        return view('item/list',[
            'categories'    => config('categories')['options'],
            'type'          => config('itemtype')['options'],
            'events'        => config('eventtag')['options'] 
        ]);
    }

    public function _list(Request $request){

        $query          = $request->input('query');
        $status         = $request->input('status');
        $category       = $request->input('category');
        $type           = $request->input('type');
        $event          = $request->input('event');
        $brand_id       = (int) $request->input('brand_id');
        $page           = (int) $request->input('page') ?? 0;
        $limit          = (int) $request->Input('limit') ?? 0;

        $item = new Item();

        
        if($event){
            $eventTag   = new EventTag();
            $item_in    = $eventTag::select('item_id')->where('event',$event)->get();
            $in = [];
        
            if($item_in){

                foreach($item_in as $itm){
                    $in[] = $itm->item_id;
                }
            }

            $item = $item::whereIn('id',$in);
        }


        if($query){
            $item = $item->where('name','LIKE','%'.$query.'%');
        }
      
        if($brand_id){
            $item = $item->where('brand_id','=',$brand_id);
        }

        if($category){
            $item = $item->where('category','=',$category);
        }

        if($type){
            $item = $item->where('type','=',$type);
        }
        
        if($status){

            json_decode($status);

            if(json_last_error() === JSON_ERROR_NONE){
             
                $in = json_decode($status,true);
                
                $item = $item->whereIn('status',$in);
            }else{
                $item = $item->where('status','=',$status);
            }
            
        }

        if($limit > 0){
            
            $page   = $page * $limit;
            $result = $item->skip($page)->take($limit)->orderBy('created_at', 'desc')->get();
            
        }else{
            $result = $item->orderBy('created_at', 'desc')->get();
        }

        for($i = 0; $i <= count($result) - 1; $i++){
            $result[$i]->photo = json_decode($result[$i]->photo);
        }

        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> $result
        ]);

    }

    public function _edit(Request $request, $id){
        
        $item = new Item();
        $item = $item::find($id);
        
        if(!$item){

            return response()->json([
                'status' => 0,
                'message'=>'Record not found',
                'data'=> []
            ]);
        }

        $name           = $request->input('name');
        $status         = $request->input('status');
        $description    = $request->input('description');
        $price          = $request->input('price');
        $expiry         = $request->input('expiry');
        $category       = $request->input('category');
        $brand          = $request->input('brand');
        $type           = $request->input('type');
        $eventTags      = $request->input('eventTags');
        
        $eventTags  = json_decode($eventTags);
        $photos     = json_decode($item->photo,true);

        $d1 = $photos['400px'] ?? '';
        $d2 = $photos['300px'] ?? '';
        $d3 = $photos['200px'] ?? '';
        $d4 = $photos['150px'] ?? '';
        
        $p1 = $request->file('400px')->store('public/photos/item/400px');
        $p2 = $request->file('300px')->store('public/photos/item/300px');
        $p3 = $request->file('200px')->store('public/photos/item/200px');
        $p4 = $request->file('150px')->store('public/photos/item/150px');

        $item->name         = $name;
        $item->status       = $status;
        $item->description  = $description;
        $item->price        = $price;
        $item->expiry       = $expiry;
        $item->category     = $category;
        $item->brand_id     = $brand;
        $item->type         = $type;
        $item->photo        = json_encode([
            '400px' => basename($p1),
            '300px' => basename($p2),
            '200px' => basename($p3),
            '150px' => basename($p4)
        ]);

        $item->modified_by = Auth::id(); 

        $item->save();

        Storage::disk('public')->delete('/photos/item/400px/'.$d1);
        Storage::disk('public')->delete('/photos/item/300px/'.$d2);
        Storage::disk('public')->delete('/photos/item/200px/'.$d3);
        Storage::disk('public')->delete('/photos/item/150px/'.$d4);

        
        $eventTag = new EventTag();
        $eventTag::where('item_id',$item->id)->delete();

        if(count($eventTags)){
                
            $data       = [];
            $eventOpt   = config('eventtag')['options'];

            foreach($eventTags as $tag){

                $data[] = [
                    'item_id'   => $item->id,
                    'brand_id'  => $brand,
                    'event'     => $tag,
                    'name'      => $eventOpt[$tag] ?? ''
                ];
            }
            
            $eventTag::insert($data);
        }

        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> [
                'id' => $item->id
            ]
        ]);
    }


    public function categoryList(){

        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> config('categories')['options']
        ]);
    }


    
    public function itemType(){

        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> config('itemtype')['options']
        ]);
    }
}

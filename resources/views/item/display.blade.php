@extends('layouts.app')

@section('content')
<div class="container">
    <h1 id="title">Display Item</h1>
    
    <form autocomplete="off">
        

        <div class="form-group mb-3">
            <label>Name</label>
            <input type="text" id="name" disabled="true" value="{{$name}}" class="form-control"/>
        </div>
        <div class="form-group mb-3">
            <label>Status</label>
            <select id="status" class="form-control" disabled="true">
                <option value="ACTV" @if ($status == 'ACTV') selected="selected" @endif>Active</option>
                <option value="ICTV" @if ($status == 'ICTV') selected="selected" @endif>Inactive</option>
                <option value="HDEN" @if ($status == 'HDEN') selected="selected" @endif>Hidden</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Brand</label>
            <select id="brand" disabled="true" class="form-control"></select>
        </div>

        <div class="form-group mb-3">
            <label>Category</label>
            <select id="category" class="form-control" disabled="true">
                @foreach(config('categories')['options'] as $i=>$txt)
                    <option value="{{$i}}"  @if($i == $category) selected="selected" @endif>{{$txt}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Type</label>
            <select id="type" class="form-control" disabled="true">
                @foreach(config('itemtype')['options'] as $i=>$txt)
                    <option value="{{$i}}"  @if($i == $type) selected="selected" @endif>{{$txt}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Description</label>
            <textarea class="form-control" id="description" disabled="true">{{$description}}</textarea>
        </div>
        <div class="form-group mb-3">
            <label>(PHP) Price</label>
            <input type="number" id="price" disabled="true" value="{{$price}}" class="form-control"/>
        </div>
        <div class="form-group mb-3">
            <label>Expiry</label>
            <input type="number" id="expiry" disabled="true" value="{{$expiry}}"  class="form-control"/>
        </div>
      
        <div class="form-group mb-3">
            <label>Event Tag</label>
            <div class="row">
                <div class="col-8">
                    <select id="eventSelect" class="form-control" disabled="true">
                        @foreach(config('eventtag')['options'] as $i=>$txt)
                            <option value="{{$i}}">{{$txt}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <button disabled="true" id="eventAddBtn" class="btn w-100 btn-warning">Add</button>
                </div>
            </div>
            <div class="row">
                <div id="eventTags" style="min-height:100px" class="mt-3 p-3 border border-warning">
                    @foreach($eventTags as $tag)
                        <span class="badge rounded-pill bg-warning m-1" style="max-height:2rem;font-size:14px">
                            {{$tag['name']}}
                            <input class="eventTag" type="hidden" value="{{$tag['event']}}"/>
                            <a href="#" class="removeEvent d-none">[X]</a>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
     
        <div class="form-group mb-3">
            <label>Photo</label>
            <div>
                <img id="preview1" class="img-thumbnail" src="{{asset('storage/photos/item/400px/'.$photo['400px'])}}" style="max-height:400px;max-width:400px;min-height:400px;min-width:400px"/>
                <img id="preview2" class="img-thumbnail" src="{{asset('storage/photos/item/300px/'.$photo['300px'])}}" style="max-height:300px;max-width:300px;min-height:300px;min-width:300px"/>
                <img id="preview3" class="img-thumbnail" src="{{asset('storage/photos/item/200px/'.$photo['200px'])}}" style="max-height:200px;max-width:200px;min-height:200px;min-width:200px"/>
                <img id="preview4" class="img-thumbnail" src="{{asset('storage/photos/item/150px/'.$photo['150px'])}}" style="max-height:150px;max-width:150px;min-height:150px;min-width:150px"/>
            </div>
            <input type="file" id="photo" class="form-control d-none"/>
        </div>

        <div class="text-end">
            <button class="btn btn-secondary" id="cancelBtn">Cancel</button>
            <button class="btn btn-warning" id="editBtn">Edit</button>
            <button class="btn btn-primary d-none" id="updateBtn">Update</button>
        </div>
    </form>

    
    <script type="module">
        import {Template} from '/adarna.js';

        const photo         = document.querySelector('#photo');
        const name          = document.querySelector('#name');
        const status        = document.querySelector('#status');
        const description   = document.querySelector('#description');
        const price         = document.querySelector('#price');
        const expiry        = document.querySelector('#expiry');
        const brand         = document.querySelector('#brand');
        const category      = document.querySelector('#category');
        const preview1      = document.querySelector('#preview1');
        const preview2      = document.querySelector('#preview2');
        const preview3      = document.querySelector('#preview3');
        const preview4      = document.querySelector('#preview4');
        const updateBtn     = document.querySelector('#updateBtn');
        const editBtn       = document.querySelector('#editBtn');
        const cancelBtn     = document.querySelector('#cancelBtn');
        const title         = document.querySelector('#title');
        const type          = document.querySelector('#type');

        const t = new Template();

        async function submitForm(){
            const formData = new FormData();

            formData.append('name',name.value);
            formData.append('status',status.value);
            formData.append('description',description.value);
            formData.append('price',price.value);
            formData.append('brand',brand.value);
            formData.append('category',category.value);
            formData.append('expiry',expiry.value);
            formData.append('type',type.value);

            let tags = [];

            Array.from(eventTags.querySelectorAll('.eventTag')).map(item=>{
                tags.push(item.value);
            });

            formData.append('eventTags',JSON.stringify(tags));

            let p1 = await util.imgToBlob(preview1);

            let p2 = await util.imgToBlob(preview2);

            let p3 = await util.imgToBlob(preview3);

            let p4 = await util.imgToBlob(preview4);

            formData.append('400px',p1);
            formData.append('300px',p2);
            formData.append('200px',p3);
            formData.append('150px',p4);


            let reply = await fetch('',
            {
                headers: {
                    "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData,
                method: "POST"
            }).then((response) => {
                return response.json()
            });


            if(!reply.status){
                alert(reply.message);
                return false;
            }

            document.location.reload();
        };

        fetch('/api/brands?'+ new URLSearchParams({
                page : 0,
                status: JSON.stringify(['ACTV','HDEN']),
                limit: 0
        })).then((response) => {
            return response.json()
        }).then(reply=>{
            
            if(!reply.status){
                alert(reply.message);
                return false;
            }

            reply.data.map(item => {

                if(item.id == '{{$brand_id}}'){
                    brand.append(t.option({value:item.id,selected:'selected'},item.name));
                }else{
                    brand.append(t.option({value:item.id},item.name));
                }

               
            });

        });
        
        editBtn.onclick = (e)=>{
            e.preventDefault();
            
            Array.from(document.querySelectorAll('.form-control,button')).map(item=>{
                item.disabled = false;
            });

            Array.from(document.querySelectorAll('.removeEvent')).map(item=>{
                item.classList.remove('d-none');
                item.onclick = (e)=>{
                    e.preventDefault();
                    item.parentElement.remove();
                }
            });
            
            editBtn.classList.add('d-none');

            updateBtn.classList.remove('d-none');
            photo.classList.remove('d-none');

            cancelBtn.onclick = (e)=>{
                e.preventDefault();
                document.location.reload();
            }

            title.innerText = 'Edit Item';
            window.scrollTo(0,0);
        }


        cancelBtn.onclick = (e)=>{
            e.preventDefault();
            document.location.href = '/items';
        }
        
        
        eventAddBtn.onclick = (e)=>{
            e.preventDefault();


            let value = eventSelect.value;
            let txt   = eventSelect.options[eventSelect.selectedIndex].innerText;

            let target = eventTags.querySelector('input[value="'+value+'"]');
            
            if(target){

                alert('Already exists');
                return false;
            }

            let tag = t.span({class:'badge rounded-pill bg-warning m-1', style:{maxHeight:'2rem',fontSize:'14px'}},()=>{
                t.txt(txt+' ');
                t.input({class:'eventTag d-none',type:'hidden',value:value})
                t.a({href:'#'},'[X]').onclick = (e)=>{
                    e.preventDefault();
                    tag.remove();
                }
            });

            eventTags.append(tag);
           
        }


        //Preview image
        photo.onchange = (e)=>{
            if(e.target.files.length > 0){
                let src = URL.createObjectURL(e.target.files[0]);
                preview1.src = src;
                preview2.src = src;
                preview3.src = src;
                preview4.src = src;
            }
        }

        updateBtn.onclick = (e)=>{
            e.preventDefault();
            submitForm();
        }

    </script>
</div>
@endsection

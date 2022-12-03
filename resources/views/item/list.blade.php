@extends('layouts.app')

@section('content')
<div class="container">
    <h1 id="title">Items</h1>
    
    <div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Search</label>
                    <input type="text" class="form-control" id="search"/>
                </div>
            </div>
            <div class="col">
            <div class="form-group">
                    <label>Status</label>
                    <select id="status" class="form-control">
                        <option value="">---</option>
                        <option value="ACTV">Active</option>
                        <option value="ICTV">Inactive</option>
                        <option value="HDEN">Hidden</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Brand</label>
                    <select class="form-control" id="brand">
                        <option value="">---</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Category</label>
                    <select class="form-control" id="category">
                        <option value="">---</option>
                        @foreach($categories as $val=>$opt)
                            <option value="{{$val}}">{{$opt}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Type</label>
                    <select class="form-control" id="type">
                        <option value="">---</option>
                        @foreach($type as $val=>$opt)
                            <option value="{{$val}}">{{$opt}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Event</label>
                    <select class="form-control" id="event">
                        <option value="">---</option>
                        @foreach($events as $val=>$opt)
                            <option value="{{$val}}">{{$opt}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="p-3 d-flex justify-content-around flex-wrap" id="list"></div>
    <div class="row">
        <div class="col">    
            <button id="showmore" class="btn btn-primary btn-block w-100 d-none">Show More</button>
        </div>
    </div>
    <script type="module">
        import {Template,$el} from '/adarna.js';
        (async ()=>{
            const list      = document.querySelector('#list');
            const search    = document.querySelector('#search');
            const brand     = document.querySelector('#brand');
            const category  = document.querySelector('#category');
            const status    = document.querySelector('#status');
            const showmore  = document.querySelector('#showmore');
            const type      = document.querySelector('#type');
            const event     = document.querySelector('#event');

            const t         = new Template();

            let page    = 0;
            let loading = false;
            
            let categories  = @json($categories);
            let itemType    = @json($type);

            let brands = await fetch('/api/brands').then((response) => {
                return response.json();
            }).then(reply=>{
                
                if(!reply.status){
                    alert(reply.message);
                    return {};
                }

                let data = {};
                
                reply.data.map(item=>{
                    data[item.id] = item;
                });

                return data;
            });
            
            for(let key in brands){

                brand.append(
                    t.option({value:brands[key].id},brands[key].name)
                );
            }
               
            

            async function showList(){
                
                loading = true;

                let reply = await fetch('/api/items?' + new URLSearchParams({
                    query       : search.value.trim(),
                    brand       : brand.value.trim(),
                    category    : category.value.trim(),
                    status      : status.value.trim(),
                    event       : event.value.trim(),
                    type        : type.value.trim(),
                    page        : page,
                    limit       : 10
                })).then((response) => {return response.json()});

                loading = false;

                if(!reply.status){
                    alert(reply.meesage);
                    return false;
                }

                page = page + 1;

                const t = new Template();

                
                if(!reply.data.length){
                    showmore.classList.add('d-none');
                }else{
                    showmore.classList.remove('d-none');
                }

                reply.data.map(item=>{
                    
                    let entry = t.div({class:'card mb-3', style:{
                        maxWidth:'300px',
                        minWidth:'300px'
                    }},()=>{

                        
                        t.div({class:'card-header'},()=>{
                            t.h5({class:'card-title'},item.name);
                        });

                        t.img({width:'300px', height:'300px',src:'{{asset("storage/photos/item/300px")}}/'+item.photo['300px'],});

                        let brand_name    = brands[item.brand_id].name ?? '';
                        let brand_id      = brands[item.brand_id].id ?? 0;
                        let category      = categories[item.category_id] ?? '';

                        t.div({class:'card-body'},()=>{
                           
                            t.div({class:'row'},()=>{
                                t.div({class:'col text-center'},item.status);
                                t.div({class:'col text-center'},itemType[item.type]);
                                
                            });
                            
                            t.div(()=>{
                                t.a({href:'/brand/display/'+brand_id},brand_name);
                            });
                            t.div(category);

                            t.div({class:'text-end'},()=>{
                                t.a({href:'/item/display/'+item.id, class:'btn btn-primary'},'View');
                            });
                            
                        });

                    });

                    $el.append(entry).to(list);

                });

            }

            function reset(){
                page            = 0;
                list.innerHTML  = '';
                showmore.classList.add('d-none');
            }



            showmore.onclick = (e)=>{
                e.preventDefault();
                showList();
            }

            search.onkeyup = (e)=>{
                if(e.keyCode == 13 && !loading){
                    reset();
                    showList();
                }
            }

            brand.onkeyup = (e) =>{
                if(e.keyCode == 13 && !loading){
                    reset();
                    showList();
                }
            }

            category.onchange = (e) =>{
                if(!loading){
                    reset();
                    showList();
                }
            }

            event.onchange = (e) =>{
                if(!loading){
                    reset();
                    showList();
                }
            }

            type.onchange = (e) =>{
                if(!loading){
                    reset();
                    showList();
                }
            }

            status.onchange = (e) =>{
                if(!loading){
                    reset();
                    showList();
                }
            }
            
            await showList();
        })();
    </script>
</div>
@endsection

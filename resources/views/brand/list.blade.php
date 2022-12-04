@extends('layouts.app')

@section('content')
<div class="container">
    <h1 id="title">Brands</h1>
    
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
        </div>
    </div>
    <div class="p-3 d-flex justify-content-around" id="list"></div>
    <div class="row">
        <div class="col">    
            <button id="showmore" class="btn btn-primary btn-block w-100 d-none">Show More</button>
        </div>
    </div>
    <script type="module">
        import {Template,$el} from '/adarna.js';

        const list      = document.querySelector('#list');
        const search    = document.querySelector('#search');
        const status    = document.querySelector('#status');
        const showmore  = document.querySelector('#showmore');
        const t         = new Template();

        let page    = 0;
        let loading = false;

        async function showList(){

            loading         = true;

            let reply = await fetch('/api/brands?' + new URLSearchParams({
                query       : search.value.trim(),
                status      : status.value.trim(),
                page        : page,
                limit       : 10
            })).then((response) => {return response.json()});

            loading = false;

            if(!reply.status){
                alert(reply.meesage);
                return false;
            }

            page++;

            const t = new Template();

            
            if(!reply.data.length){
                showmore.classList.add('d-none');
            }else{
                showmore.classList.remove('d-none');
            }

            reply.data.map(item=>{
                
                let entry = t.div({class:'card mb-3', style:{
                    maxWidth:'300px'
                }},()=>{

                    t.img({width:'300px', height:'300px',src:'{{asset("storage/photos/brand/300px")}}/'+item.photo['300px'],});

                    t.div({class:'card-body'},()=>{
                        t.h5({class:'card-title'},item.name);
                        t.p('Status: ' +item.status);
                        t.div({class:'text-end'},()=>{
                            t.a({href:'/brand/display/'+item.id, class:'btn btn-primary'},'View');
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

        showList();

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

        status.onchange = (e) =>{
            
            if(!loading){
                reset();
                showList();
            }
        }



    </script>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h1 id="title">Partners</h1>
    
   
    <div class="p-3 d-flex justify-content-around flex-wrap" id="list"></div>
    <div class="row">
        <div class="col">    
            <button id="showmore" class="btn btn-primary btn-block w-100 d-none">Show More</button>
        </div>
    </div>
    <script type="module">
        import {Template,$el,$q} from '/adarna.js';
        (async ()=>{
            const list      = $q('#list').first();
            const search    = $q('#search').first();
            const showmore  = $q('#showmore').first();
            
            const t         = new Template();

            let page    = 0;
            let loading = false;
            
            async function showList() {
            
                let result = await fetch('/api/partners',{
                    headers: {
                        "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json",
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).then((response) => {
                    return response.json();
                }).then( (reply) =>{
                    
                    if(!reply.status){
                        alert(reply.message);
                        return {};
                    }

                    console.log(reply.data);

                    reply.data.map(row=>{
                        



                    });

                });
                
                
                
            }


            showList();


               
        })();
    </script>
</div>
@endsection

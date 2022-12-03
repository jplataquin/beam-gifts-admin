@extends('layouts.app')

@section('content')
<div class="container">
    <h1 id="title">Partners</h1>
    <hr>
    
   
    <div class="p-3" id="list"></div>
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
            
                window.util.$get('/api/partners').then( (reply) =>{
                    
                    if(!reply.status){
                        alert(reply.message);
                        return {};
                    }

                    console.log(reply.data);

                    reply.data.map(row=>{
                        
                        let item = t.div({class:'card'},()=>{
                            t.div({class:'card-header'},()=>{
                               t.txt(row.brand.name);
                                
                            });

                            t.div({class:'card-body'},()=>{

                                t.div({class:'row'},()=>{
                                    t.div({class:'col-6'},()=>{
                                        t.txt(row.email);
                                    });

                                    t.div({class:'col-6'},()=>{
                                        t.txt(row.status);
                                    });
                                });
                                t.div({class:'row'},()=>{
                                    t.div({class:'col-6'},()=>{
                                        t.txt(row.primary_contact_person);
                                        t.br();
                                        t.txt(row.primary_contact_position);
                                    });

                                    t.div({class:'col-6'},()=>{
                                        t.txt(row.rimary_contact_np);
                                    });
                                });
                            });
                            
                        });


                        $el.append(item).to(list);

                    });

                });
                
                
                
            }


            showList();


               
        })();
    </script>
</div>
@endsection

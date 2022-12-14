@extends('layouts.app')

@section('content')
<div class="container">
    <h1 id="title">Partners</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Search</label>
                <input type="text" class="form-control" id="query"/>
            </div>
        </div>

        <div class="col-md-6 text-end">
            <button id="createBtn" class="btn btn-primary">Create</button>
        </div>
    </div>
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
            const query     = $q('#query').first();
            const createBtn = $q('#createBtn').first();    
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
                               t.txt(row.name+' - '+row.brand.name);
                                
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
                                    t.div({class:'col-md-6'},()=>{
                                        t.strong('Name: ');
                                        t.txt(row.primary_contact_person);
                                        t.br();
                                        t.strong('Position: ');
                                        t.txt(row.primary_contact_person_position);
                                    });

                                    t.div({class:'col-md-6'},()=>{
                                        t.strong('Phone: ');
                                        t.txt(row.primary_contact_no);
                                    });
                                });

                                t.div({class:'row'},()=>{
                                    t.div({class:'col-12 text-end'},()=>{
                                        t.a({class:'btn btn-primary',href:'/partner/'+row.id},'View');
                                    });
                                });
                            });
                            
                        });


                        $el.append(item).to(list);

                    });

                });
                
                
                
            }


            showList();

            createBtn.onclick = (e)=>{
                e.preventDefault();
                document.location.href = '/partner/create';
            }
               
        })();
    </script>
</div>
@endsection

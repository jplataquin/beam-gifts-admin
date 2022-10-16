@extends('layouts.app')

@section('content')
<div class="container">
    <h1 id="title">Display Brand</h1>
    
    <form autocomplete="off">
        <div class="form-group mb-3">
            <label>Name</label>
            <input type="text" id="name" class="form-control" value="{{$name}}" disabled="true"/>
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
            <label>Description</label>
            <textarea class="form-control" id="description" disabled="true">{{$description}}</textarea>
        </div>

        <div class="row mb-3">
            <div class="col">
                <h3>Branch list</h3>
            </div>
            <div class="col text-end">
                <button id="addBranchBtn" class="btn btn-warning d-none">Add Banch</button>
            </div>
        </div>
        <div class="container" id="branchContainer">

            @foreach($branches as $branch)
            <div class="branch border border-primary mb-3 p-3">
                <div class="form-group mb-3">
                    <label>Branch Name</label>
                    <input type="text" value="{{$branch->name}}" disabled="true" class="branch-name form-control"/>
                </div>
                <div class="form-group mb-3">
                    <label>Address</label>
                    <input type="text" value="{{$branch->address}}" disabled="true" class="branch-address form-control"/>
                </div>
                <div class="form-group mb-3">
                    <label>City</label>
                    <input type="text" value="{{$branch->city}}" disabled="true" class="branch-city form-control"/>
                </div>
                <div class="form-group mb-3">
                    <label>Contact No.</label>
                    <input type="text" value="{{$branch->phone}}" disabled="true" class="branch-phone form-control"/>
                </div>
               <div class="text-end">
                   <button class="btn btn-danger remove-branch d-none">Remove</button>
                </div>
            </div>
            @endforeach
        </div>
     
        <div class="form-group mb-3">
            <label>Banner</label>
            <div>
                <img id="bannerPreview" class="img-thumbnail"  src="{{asset('storage/photos/brand/banner/'.$photo['banner'])}}" style="max-height:300px;max-width:900px;min-height:300px;min-width:900px"/>
            </div>
            <input type="file" id="banner" class="form-control d-none"/>
        </div>

        <div class="form-group mb-3">
            <label>Logo</label>
            <div>
                <img id="preview1" class="img-thumbnail" src="{{asset('storage/photos/brand/400px/'.$photo['400px'])}}" style="max-height:400px;max-width:400px;min-height:400px;min-width:400px"/>
                <img id="preview2" class="img-thumbnail" src="{{asset('storage/photos/brand/300px/'.$photo['300px'])}}" style="max-height:300px;max-width:300px;min-height:300px;min-width:300px"/>
                <img id="preview3" class="img-thumbnail" src="{{asset('storage/photos/brand/200px/'.$photo['200px'])}}" style="max-height:200px;max-width:200px;min-height:200px;min-width:200px"/>
                <img id="preview4" class="img-thumbnail" src="{{asset('storage/photos/brand/150px/'.$photo['150px'])}}" style="max-height:150px;max-width:150px;min-height:150px;min-width:150px"/>
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
        const title             = document.querySelector('#title');
        const photo             = document.querySelector('#photo');
        const name              = document.querySelector('#name');
        const status            = document.querySelector('#status');
        const description       = document.querySelector('#description');
        const addBranchBtn      = document.querySelector('#addBranchBtn');
        const branchContainer   = document.querySelector('#branchContainer');
        const editBtn           = document.querySelector('#editBtn');
     
        const preview1      = document.querySelector('#preview1');
        const preview2      = document.querySelector('#preview2');
        const preview3      = document.querySelector('#preview3');
        const preview4      = document.querySelector('#preview4');
        const createBtn     = document.querySelector('#createBtn');

        

        async function submitForm(){
            const formData = new FormData();

            formData.append('name',name.value);
            formData.append('status',status.value);
            formData.append('description',description.value);
            
            let branches = [];

            Array.from(branchContainer.querySelectorAll('.branch')).map(item=>{

                branches.push({
                    name: item.querySelector('.branch-name').value,
                    address: item.querySelector('.branch-address').value,
                    city: item.querySelector('.branch-city').value,
                    phone: item.querySelector('.branch-phone').value
                });
            });

            formData.append('branches',JSON.stringify(branches));
       
            let p1 = await util.imgToBlob(preview1);
            let p2 = await util.imgToBlob(preview2);
            let p3 = await util.imgToBlob(preview3);
            let p4 = await util.imgToBlob(preview4);

            formData.append('400px',p1);
            formData.append('300px',p2);
            formData.append('200px',p3);
            formData.append('150px',p4);


            fetch('',
            {
                headers: {
                    "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData,
                method: "POST"
            }).then((response) => response.json())
            .then((reply=>{

                if(!reply.status){
                    alert(reply.message);
                    return;
                }
                
                document.location.href = '/brand/display/'+reply.data.id;
            }));
        };

        
        function removeBranch(target){

            let count = branchContainer.querySelectorAll('.branch').length;

            if(count > 1){
                target.remove();
            }else{
                Array.from(target.querySelectorAll('input[type="text"]')).map(item=>{
                    item.value = '';
                });
            }
        }
        
        Array.from(branchContainer.querySelectorAll('.remove-branch')).map(item=>{

            item.onclick = (e)=>{
                e.preventDefault();
                removeBranch(e.target.parentElement.parentElement);
            }
        });



        editBtn.onclick = (e)=>{
            e.preventDefault();

            Array.from(document.querySelectorAll('.d-none')).map(item=>{
                item.classList.remove('d-none');
            });

            Array.from(document.querySelectorAll('[disabled="true"]')).map(item=>{
                item.disabled = false;
            });

            editBtn.classList.add('d-none');
            
            cancelBtn.onclick = (e)=>{
                e.preventDefault();
                document.location.reload();
            }

            title.innerText = 'Edit Brand';
            window.scrollTo(0,0);
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

        addBranchBtn.onclick = (e)=>{
            e.preventDefault();
            
            let branchEl = document.querySelector('.branch').cloneNode(true);

            Array.from(branchEl.querySelectorAll('input[type="text"]')).map(item=>{
                item.value = '';
            });

       
            branchEl.querySelector('.remove-branch').onclick = (e) => {
                e.preventDefault();
                removeBranch(branchEl);
            };

            branchContainer.prepend(branchEl);
            branchEl.querySelector('input[type="text"]').focus();
        }


        cancelBtn.onclick = (e)=>{
            e.preventDefault();
            document.location.href = '/brands';
        }
    </script>
</div>
@endsection

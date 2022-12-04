@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Partner » {{$partner->id}}</h1>
    <hr>
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" id="name" value="{{$partner->name}}" disabled="true"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Brand</label>
                <select class="form-control" id="brand">
                    @foreach($brands as $brand)
                    <option value="{{$brand->id}}" @if($brand->id == $partner->brand->id) selected="true" @endif>{{$brand->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6 form-group">
            <label>Email</label>
            <input type="email" id="email" class="form-control" value="{{$partner->email}}"/>
        </div>

        <div class="col-md-6 form-group">
            <label>Status</label>
            <select id="status" class="form-control">
                <option value="PEND" @if($partner->status == "PEND") selected="true" @endif >Pending</option>
                <option value="ACTV" @if($partner->status == "ACTV") selected="true" @endif >Active</option>
                <option value="SUSP"  @if($partner->status == "SUSP") selected="true" @endif >Suspended</option>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label>Branch address</label>
                <textarea class="form-control" id="branch">{{$partner->branch}}</textarea>
            </div>
        </div>
    </div>


    <h3>Primary</h3>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label>Contact No.</label>
                <input type="text" id="primary_contact_no" value="{{$partner->primary_contact_no}}" class="form-control"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label>Contact Person</label>
                <input type="text" id="primary_contact_person" class="form-control" value="{{$partner->primary_contact_person}}"/>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <div class="form-group">
                <label>Contact Person Position</label>
                <input type="text" value="{{$partner->primary_contact_person_position}}" id="primary_contact_person_position" class="form-control"/>
            </div>
        </div>
    </div>
    
    <h3>Secondary</h3>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label>Contact No.</label>
                <input type="text" id="secondary_contact_no" value="{{$partner->secondary_contact_no}}" class="form-control"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label>Contact Person</label>
                <input type="text" id="secondary_contact_person" class="form-control" value="{{$partner->secondary_contact_person}}"/>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <div class="form-group">
                <label>Contact Person Position</label>
                <input type="text" value="{{$partner->secondary_contact_person_position}}" id="secondary_contact_person_position" class="form-control"/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 text-end">
            <button id="updateBtn" class="btn btn-warning">Update</button>
            <button id="cancelBtn" class="btn btn-primary">Cancel</button>
        </div>
    </div>

</div>

<script type="module">
    import {$q,util} from '/adarna.js';

    const updateBtn = $q('#updateBtn').first();
    const cancelBtn = $q('#cancelBtn').first();

    const name = $q('#name').first();
    const brand = $q('#brand').first();
    const email = $q('#email').first();
    const status = $q('#status').first();
    const branch = $q('#branch').first();

    const primary_contact_person            = $q('#primary_contact_person').first();
    const primary_contact_no                = $q('#primary_contact_no').first();
    const primary_contact_person_position   = $q('#primary_contact_person_position').first();

    const secondary_contact_person            = $q('#secondary_contact_person').first();
    const secondary_contact_no                = $q('#secondary_contact_no').first();
    const secondary_contact_person_position   = $q('#secondary_contact_person_position').first();

    updateBtn.onclick = (e)=>{

        if(!confirm('Are you sure you want to update this record?')){
            return false;
        }

        window.util.$post('/partner/{{$partner->id}}',{
            name        : name.value,
            brand_id    : brand.value,
            email       : email.value,
            status      : status.value,
            branch      : branch.value,

            primary_contact_person: primary_contact_person.value,
            primary_contact_no: primary_contact_no.value,
            primary_contact_person_position: primary_contact_person_position.value,

            secondary_contact_person: secondary_contact_person.value,
            secondary_contact_no: secondary_contact_no.value,
            secondary_contact_person_position: secondary_contact_person_position.value,
        }).then(reply=>{

            if(reply.status <= 0){
                alert(reply.message);
                return false;
            }

            document.location.reload();
        });
    }
    
</script>
@endsection
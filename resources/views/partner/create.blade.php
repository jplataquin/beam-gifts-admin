@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Partner</h1>
    
    <div class="row mb-3">
        <div class="col form-group">
            <label>Brand</label>
            <input type="text" id="brand" class="form-control"/>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col form-group">
            <label>Branch Address</label>
            <textarea id="branch" class="form-control"></textarea>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col form-group">
            <label>Email</label>
            <input type="email" id="email" class="form-control"/>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col form-group">
            <label>Username</label>
            <input type="text" id="username" class="form-control"/>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col form-group">
            <label>Status</label>
            <select id="status" class="form-control">
                <option value="PEND">Pending</option>
                <option value="ACTV">Active</option>
                <option value="SUSP">Suspended</option>
            </select>
        </div>
    </div>

    <h3>Primary</h3>
    <div class="row">
        <div class="col form-group">
            <label>Contact No.</label>
            <input type="text" id="primary_contact_no" class="form-control"/>
        </div>
    </div>
    <div class="row">
        <div class="col form-group">
            <label>Contact Person</label>
            <input type="text" id="primary_contact_person" class="form-control"/>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col form-group">
            <label>Contact Person Position</label>
            <input type="text" id="primary_contact_person_position" class="form-control"/>
        </div>
    </div>
    
    <h3>Secondary</h3>
    <div class="row">
        <div class="col form-group">
            <label>Contact No.</label>
            <input type="text" id="secondary_contact_no" class="form-control"/>
        </div>
    </div>
    <div class="row">
        <div class="col form-group">
            <label>Contact Person</label>
            <input type="number" id="secondary_contact_person" class="form-control"/>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col form-group">
            <label>Contact Person Position</label>
            <input type="text" id="secondary_contact_person_position" class="form-control"/>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col text-end">
            <button class="btn btn-secondary" id="cancelBtn">Submit</button>
            <button class="btn btn-primary" id="submitBtn">Submit</button>
        </div>
    </div>
</div>
<script type="module">

    const submitBtn = document.querySelector('#submitBtn');
    const cancelBtn = document.querySelector('#cancelBtn');

    const brand     = document.querySelector('#brand');
    const email     = document.querySelector('#email');
    const branch    = document.querySelector('#branch');
    const usename   = document.querySelector('#usenrame');
    const status    = document.querySelector('#status');

    const primary_contact_person            = document.querySelector('#primary_contact_person');
    const primary_contact_no                = document.querySelector('#primary_contact_no');
    const primary_contact_person_position   = document.querySelector('#primary_contact_person_position');
   
    const secondary_contact_person          = document.querySelector('#secondary_contact_person');
    const secondary_contact_no              = document.querySelector('#secondary_contact_no');
    const secondary_contact_person_position = document.querySelector('#secondary_contact_person_position');

    submitBtn.onclick = (e)=>{
        e.preventDefault();

        const formData = new FormData();

        //Todo client side validation

        formData.append('brand',brand.value);
        formData.append('email',email.value);
        formData.append('branch',branch.value);
        formData.append('status',status.value);

        formData.append('primary_contact_no',primary_contact_no.value);
        formData.append('primary_contact_person',primary_contact_person.value);
        formData.append('primary_contact_person_position',primary_contact_person_position.value);

        formData.append('secondary_contact_no',secondary_contact_no.value);
        formData.append('secondary_contact_person',secondary_contact_person.value);
        formData.append('secondary_contact_person_position',secondary_contact_person_position.value);

        window.util.$post('',formData).then(reply=>{
            console.log(reply);
        });
    }
</script>
@endsection
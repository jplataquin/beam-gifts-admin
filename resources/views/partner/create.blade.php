@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Partner</h1>
    
    <div class="row">
        <div class="col form-group">
            <label>Brand</label>
            <input type="text" id="brand" class="form-control"/>
        </div>
    </div>

    <div class="row">
        <div class="col form-group">
            <label>Branch Address</label>
            <textarea id="branch" class="form-control"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col form-group">
            <label>Email</label>
            <input type="email" id="email" class="form-control"/>
        </div>
    </div>

    <h3>Primary</h3>
    <div class="row">
        <div class="col form-group">
            <label>Contact No.</label>
            <input type="number" id="primary_contact_no" class="form-control"/>
        </div>
    </div>
    <div class="row">
        <div class="col form-group">
            <label>Contact Person</label>
            <input type="text" id="primary_contact_person" class="form-control"/>
        </div>
    </div>
    <div class="row">
        <div class="col form-group">
            <label>Contact Person Position</label>
            <input type="text" id="primary_contact_person_position" class="form-control"/>
        </div>
    </div>
    
    <h3>Secondary</h3>
    <div class="row">
        <div class="col form-group">
            <label>Contact No.</label>
            <input type="number" id="secondary_contact_no" class="form-control"/>
        </div>
    </div>
    <div class="row">
        <div class="col form-group">
            <label>Contact Person</label>
            <input type="number" id="secondary_contact_person" class="form-control"/>
        </div>
    </div>
    <div class="row">
        <div class="col form-group">
            <label>Contact Person Position</label>
            <input type="text" id="secondary_contact_person_position" class="form-control"/>
        </div>
    </div>

    <div class="row">
        <div class="col text-end">
            <button class="btn btn-primary" id="submitBtn">Submit</button>
        </div>
    </div>
</div>
@endsection
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

    <div class="row">
        <div class="col form-group">
            <label>Primary Contact No.</label>
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
            <label>Primary Contact Person Position</label>
            <input type="text" id="primary_contact_person_position" class="form-control"/>
        </div>
    </div>
    
    <div class="row">
        <div class="col form-group">
            <label>Secondary Contact No.</label>
            <input type="number" id="secondary_contact_no" class="form-control"/>
        </div>
    </div>
    <div class="row">
        <div class="col form-group">
            <label>Secondary Contact Person</label>
            <input type="number" id="secondary_contact_person" class="form-control"/>
        </div>
    </div>
    <div class="row">
        <div class="col form-group">
            <label>Secondary Contact Person Position</label>
            <input type="text" id="secondary_contact_person_position" class="form-control"/>
        </div>
    </div>

    <div class="row">
        <div class="col text-end">
            <button id="submitBtn">Submit</button>
        </div>
    </div>
</div>
@endsection
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
        <div class="col form-group">
            <label>Branch Address</label>
            <textarea id="branch" class="form-control">{{$partner->branch}}</textarea>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col form-group">
            <label>Email</label>
            <input type="email" id="email" class="form-control" value="{{$partner->email}}"/>
        </div>
    </div>
</div>
@endsection
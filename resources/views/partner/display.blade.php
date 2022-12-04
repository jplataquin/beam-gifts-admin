@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Partner » {{$partner->id}}</h1>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Name</label>
                <input type="text" id="name" value="{{$partner->name}}" disabled="true"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Brand</label>
                <select>
                    @foreach($brands as $brand)
                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
@endsection
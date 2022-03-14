@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Create New Form</h2>
    @if(count($errors) > 0)
        @foreach($errors->all() as $error)
            <div class="alert alert-danger">
            {{$error}}
            </div>
        @endforeach
        
    @endif
    @if(Session::has('success'))
    <div class="alert alert-success">
        {{Session::get('success')}}
    </div>
    @endif 
    <form name="createform" method="post" action="{{url('/admin/createform')}}">
        @csrf
        <div class="form-group" >
            <label for="label title">Please enter label:</label>    
            <input type="text" name="field_title" placeholder="Please enter label" required />
        </div>
        <div class="form-group">
            <label for="field">Select Field Type</label>
            <select name="field_type" required>
                <option value="text">Text</option>
                <option value="email">Email</option>
                <option value="password">Password</option>
            </select>
        </div>
        <div class="form-group">
            <h3>Validation rules</h3>
            <label for="minval">Minimum Value:</label>
            <div class="col-md-4"> <input type="checkbox" name="ismin" value="1">
                <input type="text" name="minval" value="">
            </div> 
            <label for="maxval">Maximum Value:</label>
            <div class="col-md-4"> <input type="checkbox" name="ismax" value="1">
                <input type="text" name="maxval" value="">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <input type="submit" name="create" class="btn btn-primary" value="Create">
            </div>  
        </div>
    </form>
</div>
@endsection

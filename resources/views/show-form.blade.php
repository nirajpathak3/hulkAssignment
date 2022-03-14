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
    @if($data)
    <?php $fielddata = json_decode($data->post_content);?>
    
    <form name="createform" method="post" action="{{url('/user/submitform')}}">
        @csrf
        <div class="form-group" >
            <label for="label title">{{$data->post_title}}:</label>    
            <input type="{{$fielddata->field_type}}" name="field_data" @if(isset($fielddata->min)) min="{{$fielddata->min}}" @endif @if(isset($fielddata->max)) max="{{$fielddata->max}}" @endif required />
            <input type="hidden" name="user_id" value="@if(Auth::check()){{Auth::user()->id}}@endif">
            <input type="hidden" name="form_id" value="{{$data->id}}">
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <input type="submit" name="create" class="btn btn-primary" value="Create">
            </div>  
        </div>
    </form>
    @else
        No Content to show!
    @endif
</div>
@endsection

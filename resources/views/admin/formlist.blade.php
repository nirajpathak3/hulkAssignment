@extends('layouts.app')
<style>
    table.formlist th, table.formlist td {
        border: 2px solid;
        padding: 10px;
    }
</style>
@section('content')

<div class="container">
    <h2>List Of All Forms:</h2>
    @if(Session::has('success'))
    <div class="alert alert-success">
        {{Session::get('success')}}
    </div>
    @endif 
    @if($data)
        <?php $sno = 1;?>
        <table class="formlist" >
            <thead>
                <th>S.no</th>
                <th>Post Title</th>
                <th>post Url</th>
                <th>Total Submits</th>
                <th>Total Opens</th>
            </thead>
            <tbody>
                @foreach($data as $formdata)
                <tr>
                    <td>{{$sno++}}</td>
                    <td>{{$formdata->post_title}}</td>
                    <td>{{$formdata->post_url}}</td>
                    <td>{{$formdata->total_submit_count}}</td>
                    <td>{{$formdata->total_open_count}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        No Content to show!
    @endif
</div>
@endsection

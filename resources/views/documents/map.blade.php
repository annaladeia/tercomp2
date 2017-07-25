@extends('layouts.master')

@section('content')

<h1>{{ $data->name }}</h1>
<hr>

<div style="height:100vh;margin-top:-245px;position:relative;">
    <div id="cy" style="position:absolute;left:0;top:245px;right:0;bottom:0;"></div>
</div>


<div class="row">

    <div class="col-md-12 text-right">
        <a href="{{ route('documents.show', $data->id) }}" class="btn btn-link">Back</a>
    </div>
</div>

<input type="hidden" name="documentID" value="{{$data->id}}" />


@stop
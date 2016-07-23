@extends('layouts.master')

@section('content')

<h1>{{ $data->name }}</h1>
<p class="lead">{{ $data->first_name }}</p>
<hr>

<dl class="dl-horizontal">
    <dt>Autre renseigment</dt>
    <dd>{!! nl2br(e($data->comments)) !!}</dd>
</dl>


<div class="row">

    <div class="col-md-12 text-right">
        <a href="{{ route('references.edit', $data->id) }}" class="btn btn-primary pull-right">Edit Confront</a>
        <div class="pull-right">&nbsp;</div>
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['references.destroy', $data->id],
            'class' => 'pull-right'
        ]) !!}
            {!! Form::submit('Delete Confront', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
        <div class="pull-right">&nbsp;</div>
        <a href="{{ route('references.index') }}" class="btn btn-link">Back to all Confronts</a>
    </div>
</div>



@stop
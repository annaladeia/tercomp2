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
        <a href="{{ route('places.edit', $data->id) }}" class="btn btn-primary pull-right">Edit Toponyme</a>
        <div class="pull-right">&nbsp;</div>
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['places.destroy', $data->id],
            'class' => 'pull-right'
        ]) !!}
            {!! Form::submit('Delete Toponyme', ['class' => 'btn btn-confirm-delete btn-danger']) !!}
        {!! Form::close() !!}
        <div class="pull-right">&nbsp;</div>
        <a href="{{ route('places.index') }}" class="btn btn-link">Back to all Entités toponymiques</a>
    </div>
</div>



@stop
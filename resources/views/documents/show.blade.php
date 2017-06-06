@extends('layouts.master')

@section('content')

<h1>{{ $data->name }}</h1>
<p class="lead">{{ $data->first_name }}</p>
<hr>

<dl class="dl-horizontal">
    <dt>An</dt>
    <dd>{!! nl2br(e($data->year)) !!}</dd>
    
    <dt>Type</dt>
    <dd>{!! nl2br(e($data->type)) !!}</dd>
</dl>


<div class="row">

    <div class="col-md-12 text-right">
        <a href="{{ route('documents.edit', $data->id) }}" class="btn btn-primary pull-right">Edit Document</a>
        <div class="pull-right">&nbsp;</div>
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['documents.destroy', $data->id],
            'class' => 'pull-right'
        ]) !!}
            {!! Form::submit('Delete Document', ['class' => 'btn btn-confirm-delete btn-danger']) !!}
        {!! Form::close() !!}
        <div class="pull-right">&nbsp;</div>
        <a href="{{ route('documents.index') }}" class="btn btn-link">Back to all Documents</a>
    </div>
</div>



@stop
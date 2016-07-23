@extends('layouts.master')

@section('content')

<h1>Toponymes</h1>
<p class="lead">Here's a list of all toponymes. <a href="{{ route('places.create') }}">Add a new one?</a></p>
<hr>

@include('partials.alerts.success')

<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Nom</th>
        <th></th>
    </tr>
@foreach($data as $data)
    <tr>
        <td>{{ $data->id }}</td>
        <td>{{ $data->name }}</td>
        <td class="text-right"><a href="{{ route('places.show', $data->id) }}" class="btn btn-sm btn-info">View</a>
        <a href="{{ route('places.edit', $data->id) }}" class="btn btn-sm btn-primary">Edit</a>&nbsp;
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['places.destroy', $data->id],
            'class' => 'pull-right'
        ]) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) !!}
        {!! Form::close() !!}</td>
    </tr>
@endforeach
</table>


    <a href="{{ route('places.create') }}" class="btn btn-success pull-right">Add new Toponyme</a>

@stop
@extends('layouts.master')

@section('content')

<h1>Confronts</h1>
<p class="lead">Here's a list of all confronts. <a href="{{ route('references.create') }}">Add a new one?</a></p>
<hr>

@include('partials.alerts.success')

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Nom</th>
            <th class="no-sort"></th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $data)
        <tr>
            <td>{{ $data->id }}</td>
            <td>{{ $data->name }}</td>
            <td class="text-right"><a href="{{ route('references.show', $data->id) }}" class="btn btn-sm btn-info">View</a>
            <a href="{{ route('references.edit', $data->id) }}" class="btn btn-sm btn-primary">Edit</a>&nbsp;
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['references.destroy', $data->id],
                'class' => 'pull-right'
            ]) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-confirm-delete btn-sm btn-danger']) !!}
            {!! Form::close() !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<br/><a href="{{ route('references.create') }}" class="btn btn-success pull-right">Add new Confront</a>

@stop
@extends('layouts.master')

@section('content')

<h1>Natures</h1>
<p class="lead">Here's a list of all natures. <a href="{{ route('parceltypes.create') }}">Add a new one?</a></p>
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
            <td class="text-right"><a href="{{ route('parceltypes.show', $data->id) }}" class="btn btn-sm btn-info">View</a>
            <a href="{{ route('parceltypes.edit', $data->id) }}" class="btn btn-sm btn-primary">Edit</a>&nbsp;
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['parceltypes.destroy', $data->id],
                'class' => 'pull-right'
            ]) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) !!}
            {!! Form::close() !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<br/><a href="{{ route('parceltypes.create') }}" class="btn btn-success pull-right">Add new Nature</a>

@stop
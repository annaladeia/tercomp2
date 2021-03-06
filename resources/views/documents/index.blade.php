@extends('layouts.master')

@section('content')

<h1>Documents</h1>
<p class="lead">Here's a list of all documents. <a href="{{ route('documents.create') }}">Add a new one?</a></p>
<hr>

@include('partials.alerts.success')

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Nom</th>
            <th>An</th>
            <th>Type</th>
            <th class="table__buttons no-sort"></th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $data)
        <tr>
            <td>{{ $data->id }}</td>
            <td>{{ $data->name }}</td>
            <td>{{ $data->year }}</td>
            <td>{{ $data->type }}</td>
            <td class="table__buttons text-right"><a href="{{ route('documents.show', $data->id) }}" title="View record" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
            <a href="{{ route('documents.edit', $data->id) }}" title="Edit record" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>&nbsp;
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['documents.destroy', $data->id],
                'class' => 'pull-right'
            ]) !!}
                <button type="submit" class="btn btn-confirm-delete btn-sm btn-danger" title="Delete record"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            {!! Form::close() !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<br/><a href="{{ route('documents.create') }}" class="btn btn-success pull-right">Add new Document</a>

@stop


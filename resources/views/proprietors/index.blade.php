@extends('layouts.master')

@section('content')

<h1>Propriétaires</h1>
<p class="lead">Here's a list of all propriétaires. <a href="{{ route('proprietors.create') }}">Add a new one?</a></p>
<hr>

@include('partials.alerts.success')

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Surnom</th>
            <th>Folio</th>
            <th>Discriminateur</th>
            <th>Lieu de residence</th>
            <th>Métier / Statut</th>
            <th class="no-sort"></th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $data)
        <tr>
            <td>{{ $data->id }}</td>
            <td>{{ $data->name }}</td>
            <td>{{ $data->first_name }}</td>
            <td>{{ $data->nickname }}</td>
            <td>{{ $data->page }}</td>
            <td>{{ $data->differential }}</td>
            <td>{{ $data->residence }}</td>
            <td>{{ $data->occupation }}</td>
            <td class="text-right"><a href="{{ route('proprietors.show', $data->id) }}" class="btn btn-sm btn-info">View</a>
            <a href="{{ route('proprietors.edit', $data->id) }}" class="btn btn-sm btn-primary">Edit</a>&nbsp;
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['proprietors.destroy', $data->id],
                'class' => 'pull-right'
            ]) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) !!}
            {!! Form::close() !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>


<br/><a href="{{ route('proprietors.create') }}" class="btn btn-success pull-right">Add new Propriétaire</a>

@stop
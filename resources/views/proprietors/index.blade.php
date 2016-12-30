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
            <th>Métier(s)</th>
            <th>Discriminateur</th>
            <th>Lieu de residence</th>
            <th class="table__buttons no-sort"></th>
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
            <td>{{ $data->professions_display }}</td>
            <td>{{ $data->differential }}</td>
            <td>{{ $data->residence }}</td>
            <td class="table__buttons text-right"><a href="{{ route('proprietors.show', $data->id) }}" title="View record" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
            <a href="{{ route('proprietors.edit', $data->id) }}" title="Edit record" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>&nbsp;
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['proprietors.destroy', $data->id],
                'class' => 'pull-right'
            ]) !!}
                <button type="submit" class="btn btn-confirm-delete btn-sm btn-danger" title="Delete record"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            {!! Form::close() !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>


<br/><a href="{{ route('proprietors.create') }}" class="btn btn-success pull-right">Add new Propriétaire</a>

@stop
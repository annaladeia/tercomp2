@extends('layouts.master')

@section('content')

<h1>Parcelles</h1>
<p class="lead">Here's a list of all parcelles. <a href="{{ route('parcels.create') }}">Add a new one?</a></p>
<hr>

@include('partials.alerts.success')

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Propriétaire(s)</th>
            <th>Page / folio</th>
            <th class="no-sort"></th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $data)
        <tr>
            <td>{{ $data->id }}</td>
            <td>@for ($i = 0; $i < count($data->proprietors); $i++) @if ($i > 0) - @endif {{ $data->proprietors[$i]->field_display }} @endfor</td>
            
            <td>{{ $data->page_number }} ({{ $data->front ? 'recto' : 'verso'}})</td>
            <td class="text-right"><a href="{{ route('parcels.show', $data->id) }}" class="btn btn-sm btn-info">View</a>
            <a href="{{ route('parcels.edit', $data->id) }}" class="btn btn-sm btn-primary">Edit</a>&nbsp;
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['parcels.destroy', $data->id],
                'class' => 'pull-right'
            ]) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) !!}
            {!! Form::close() !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>


<br/><a href="{{ route('parcels.create') }}" class="btn btn-success pull-right">Add new Parcelle</a>

@stop
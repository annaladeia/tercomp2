@extends('layouts.master')

@section('content')

<h1>Entités toponymiques</h1>
<p class="lead">Here's a list of all toponymes. <a href="{{ route('places.create') }}">Add a new one?</a></p>
<hr>

@include('partials.alerts.success')

{!! Form::model(array(), [
    'method' => 'POST',
    'action' => 'PlacesController@replacePlace',
]) !!}

<div class="form-inline form-group">
    <div class="form-group">
        <label for="replacement">Replace with:</label>
    </div>
    <div class="form-group" style="width: 300px;">
        <select class="js-replace-target" name="replacement" id="replacement">
            <option value="">Select a confront</option>
            @foreach($data as $item)
            <option value="{{ $item->id }}">{{ $item->id }} - {{ $item->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <td></td>
            <th>#</th>
            <th>Nom</th>
            <th class="table__buttons no-sort"></th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $item)
        <tr>
            <td>{!! Form::checkbox('items[]', $item->id, 0, ['class' => 'js-replace-item']) !!}</td>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td class="table__buttons text-right"><a href="{{ route('places.show', $item->id) }}" title="View record" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
            <a href="{{ route('places.edit', $item->id) }}" title="Edit record" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>&nbsp;
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['places.destroy', $item->id],
                'class' => 'pull-right'
            ]) !!}
                <button type="submit" class="btn btn-confirm-delete btn-sm btn-danger" title="Delete record"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            {!! Form::close() !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<br/><a href="{{ route('places.create') }}" class="btn btn-success pull-right">Add new Toponyme</a>

{!! Form::close() !!}

@stop
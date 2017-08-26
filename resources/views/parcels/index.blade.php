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
            <th>Entité(s) toponymique(s)</th>
            <th>Nature(s)</th>
            <th class="text-right">Arpent</th>
            <th class="text-right">Seteree</th>
            <th class="text-right">Pugnerade</th>
            <th class="text-right">Coup</th>
            <th class="text-right">Canne</th>
            <th class="text-right">Livre(s)</th>
            <th class="text-right">Sous</th>
            <th class="text-right">Denier(s)</th>
            <th>Doute</th>
            <th>Folio</th>
            <th class="table__buttons no-sort"></th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $p)
        <tr>
            <td>{{ $p->id }}</td>
            <td>@for ($i = 0; $i < count($p->proprietors); $i++) @if ($i > 0) - @endif {{ $p->proprietors[$i]->field_display }} @endfor</td>
            <td>@for ($i = 0; $i < count($p->places); $i++) @if ($i > 0) - @endif {{ $p->places[$i]->name }} @endfor</td>
            <td>@for ($i = 0; $i < count($p->parcelTypes); $i++) @if ($i > 0) - @endif {{ $p->parcelTypes[$i]->name }} @endfor</td>
            <td class="text-right">{{ number_format($p->arpent, 2) }}</td>
            <td class="text-right">{{ number_format($p->seteree, 2) }}</td>
            <td class="text-right">{{ number_format($p->pugnerade, 2) }}</td>
            <td class="text-right">{{ number_format($p->coup, 2) }}</td>
            <td class="text-right">{{ number_format($p->canne, 2) }}</td>
            <td class="text-right">{{ number_format($p->livre, 2) }}</td>
            <td class="text-right">{{ number_format($p->sous, 2) }}</td>
            <td class="text-right">{{ number_format($p->denier, 2) }}</td>
            <td>{{ $p->field_uncertain ? 'Oui' : 'Non'}}</td>
            <td>{{ $p->page_number }} ({{ $p->front ? 'recto' : 'verso'}})</td>
            <td class="table__buttons text-right"><a href="{{ route('parcels.show', $p->id) }}" title="View record" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
            <a href="{{ route('parcels.edit', $p->id) }}" title="Edit record" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>&nbsp;
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['parcels.destroy', $p->id],
                'class' => 'pull-right'
            ]) !!}
                <button type="submit" class="btn btn-confirm-delete btn-sm btn-danger" title="Delete record"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            {!! Form::close() !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>


<br/><a href="{{ route('parcels.create') }}" class="btn btn-success pull-right">Add new Parcelle</a>

@stop
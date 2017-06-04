@extends('layouts.master')

@section('content')

<h1>Parcelle ID {{$data->id}}</h1>
<p class="lead">@for ($i = 0; $i < count($data->proprietors); $i++) @if ($i > 0) - @endif {{ $data->proprietors[$i]->field_display }} @endfor</p>
<hr>

@include('partials.alerts.success')

<dl class="dl-horizontal">
    <dt>Page / folio</dt>
    <dd>{{ $data->page_number }} ({{ $data->front ? 'recto' : 'verso'}})</dd>
    <dt>Nr. de parcelle de la page</dt>
    <dd>{{ $data->parcel_number }}</dd>
    <dt>Propriétaire(s)</dt>
    <dd>
    @foreach ($data->proprietors as $proprietor)
    <a href="{{ route('proprietors.show', $proprietor->id) }}">{{ $proprietor->field_display }}</a><br/>
    @endforeach
    </dd>
    <dt>Entité(s) toponymique</dt>
    <dd>
    @foreach ($data->places as $place)
    <a href="{{ route('places.show', $place->id) }}">{{ $place->field_display }}</a><br/>
    @endforeach
    </dd>
    <dt>Nature de la parcelle</dt>
    <dd>
    @foreach ($data->parcelTypes as $type)
    <a href="{{ route('parceltypes.show', $type->id) }}">{{ $type->field_display }}</a><br/>
    @endforeach
    </dd>
    <dt>Confronts</dt>
    <dd>
    @foreach ($data->parcelConnections as $connection)
    @if ($connection->orientation === 1) Septentrion
    @elseif ($connection->orientation === 2) Levant
    @elseif ($connection->orientation === 3) Midi
    @elseif ($connection->orientation === 4) Couchant
    @endif
    avec 
    @if (count($connection->proprietors) > 0) propriétaire voisin 
    @foreach ($connection->proprietors as $p)
    <a href="{{ route('proprietors.show', $p->id) }}">{{$p->field_display}}</a>
    @endforeach
    @else confront invariant <a href="{{ route('references.show', $connection->reference->id) }}">{{$connection->reference->field_display}}</a>
    @endif
    @if (trim($connection->comments)) ({{$connection->comments}}) @endif
    <br/>
    @endforeach
    </dd>
    <dt>Arpent</dt>
    <dd>{{$data->arpent}} @if ($data->arpent != $data->arpent_input) ou {{$data->arpent_input}} @endif</dd>
    <dt>Seteree</dt>
    <dd>{{$data->seteree}} @if ($data->seteree != $data->seteree_input) ou {{$data->seteree_input}} @endif</dd>
    <dt>Pugnerade</dt>
    <dd>{{$data->pugnerade}} @if ($data->pugnerade != $data->pugnerade_input) ou {{$data->pugnerade_input}} @endif</dd>
    <dt>Coup</dt>
    <dd>{{$data->coup}} @if ($data->coup != $data->coup_input) ou {{$data->coup_input}} @endif</dd>
    <dt>Canne</dt>
    <dd>{{$data->canne}} @if ($data->canne != $data->canne_input) ou {{$data->canne_input}} @endif</dd>
    <dt>Livre</dt>
    <dd>{{$data->livre}} @if ($data->livre != $data->livre_input) ou {{$data->livre_input}} @endif</dd>
    <dt>Sous</dt>
    <dd>{{$data->sous}} @if ($data->sous != $data->sous_input) ou {{$data->sous_input}} @endif</dd>
    <dt>Denier(s)</dt>
    <dd>{{$data->denier}} @if ($data->denier != $data->denier_input) ou {{$data->denier_input}} @endif</dd>
    <dt>Autre renseigment</dt>
    <dd>{!! nl2br(e($data->comments)) !!}</dd>
</dl>


<div class="row">

    <div class="col-md-12 text-right">
        <a href="{{ route('parcels.edit', $data->id) }}" class="btn btn-primary pull-right">Edit Parcelle</a>
        <div class="pull-right">&nbsp;</div>
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['parcels.destroy', $data->id],
            'class' => 'pull-right'
        ]) !!}
            {!! Form::submit('Delete Parcelle', ['class' => 'btn btn-confirm-delete btn-danger']) !!}
        {!! Form::close() !!}
        <div class="pull-right">&nbsp;</div>
        <a href="{{ route('parcels.index') }}" class="btn btn-link">Back to all Parcelles</a>
    </div>
</div>



@stop
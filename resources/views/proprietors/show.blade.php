@extends('layouts.master')

@section('content')

<h1>{{ $data->name }}</h1>
<p class="lead">{{ $data->first_name }}</p>
<hr>

<dl class="dl-horizontal">
    <dt>Institution</dt>
    <dd>{{ $data->institution }}</dd>
    <dt>Surnom</dt>
    <dd>{{ $data->nickname }}</dd>
    <dt>Folio</dt>
    <dd>{{ $data->page }}</dd>
    <dt>Discriminateur</dt>
    <dd>{{ $data->differential }}</dd>
    <dt>Lien Familial</dt>
    <dd>
    @foreach ($data->relatedProprietors as $proprietor)
    {{ $proprietor->family_relation }} de <a href="{{ route('proprietors.show', $proprietor->id) }}">{{ $proprietor->field_display }}</a><br/>
    @endforeach
    </dd>
    <dt></dt>
    <dd></dd>
    <dt>Lieu de residence</dt>
    <dd>{{ $data->residence }}</dd>
    <dt>Métier(s)</dt>
    <dd>{{ $data->professions_display }}</dd>
    <dt>Parcelles</dt>
    <dd>
    @foreach ($data->parcels as $parcel)
    <a href="{{ route('parcels.show', $parcel->id) }}">Parcelle ID {{ $parcel->id }}</a><br/>
    @endforeach
    </dd>
    <dt>Autre renseigment</dt>
    <dd>{!! nl2br(e($data->comments)) !!}</dd>
</dl>


<div class="row">

    <div class="col-md-12 text-right">
        <a href="{{ route('proprietors.edit', $data->id) }}" class="btn btn-primary pull-right">Edit Propriétaire</a>
        <div class="pull-right">&nbsp;</div>
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['proprietors.destroy', $data->id],
            'class' => 'pull-right'
        ]) !!}
            {!! Form::submit('Delete Propriétaire', ['class' => 'btn btn-confirm-delete btn-danger']) !!}
        {!! Form::close() !!}
        <div class="pull-right">&nbsp;</div>
        <a href="{{ route('proprietors.index') }}" class="btn btn-link">Back to all Propriétaires</a>
    </div>
</div>



@stop
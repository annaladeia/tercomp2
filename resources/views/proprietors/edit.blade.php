@extends('layouts.master')

@section('content')

<h1>Edit Propriétaire - {{ $data->name }}</h1>
<p class="lead">Edit this Propriétaire below. <a href="{{ route('proprietors.index') }}">Go back to all Propriétaires.</a></p>
<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success')

@include('partials.forms.proprietors')

@stop
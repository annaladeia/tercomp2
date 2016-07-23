@extends('layouts.master')

@section('content')

<h1>New Parcelle</h1>
<p class="lead">Add a new parcelle below. <a href="{{ route('parcels.index') }}">Go back to all Parcelles.</a></p>
<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success')

@include('partials.forms.parcels')


@stop
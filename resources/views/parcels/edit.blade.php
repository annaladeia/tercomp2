@extends('layouts.master')

@section('content')

<h1>Edit Parcelle</h1>
<p class="lead">Edit this Parcelle below. <a href="{{ route('parcels.index') }}">Go back to all Parcelles.</a></p>
<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success')

@include('partials.forms.parcels')

@stop
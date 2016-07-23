@extends('layouts.master')

@section('content')

<h1>Edit Toponyme - {{ $data->name }}</h1>
<p class="lead">Edit this Toponyme below. <a href="{{ route('places.index') }}">Go back to all Toponymes.</a></p>
<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success')

@include('partials.forms.places')

@stop
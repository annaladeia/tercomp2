@extends('layouts.master')

@section('content')

<h1>New Toponyme</h1>
<p class="lead">Add a new toponyme below. <a href="{{ route('places.index') }}">Go back to all Toponymes.</a></p>
<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success')

@include('partials.forms.places')


@stop
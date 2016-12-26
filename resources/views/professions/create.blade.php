@extends('layouts.master')

@section('content')

<h1>New Métier</h1>
<p class="lead">Add a new métier below. <a href="{{ route('professions.index') }}">Go back to all Métiers.</a></p>
<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success')

@include('partials.forms.professions')


@stop
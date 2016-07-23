@extends('layouts.master')

@section('content')

<h1>New Confront</h1>
<p class="lead">Add a new confront below. <a href="{{ route('references.index') }}">Go back to all Confronts.</a></p>
<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success')

@include('partials.forms.references')


@stop
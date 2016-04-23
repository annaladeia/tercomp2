@extends('layouts.master')

@section('content')

<h1>New Propriétaire</h1>
<p class="lead">Add a new propriétaire below. <a href="{{ route('proprietors.index') }}">Go back to all Propriétaires.</a></p>
<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success')

@include('partials.forms.proprietors')


@stop
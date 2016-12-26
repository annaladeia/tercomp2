@extends('layouts.master')

@section('content')

<h1>Edit Métier - {{ $data->name }}</h1>
<p class="lead">Edit this Métier below. <a href="{{ route('professions.index') }}">Go back to all Métiers.</a></p>
<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success')

@include('partials.forms.professions')

@stop
@extends('layouts.master')

@section('content')

<h1>Edit Confront - {{ $data->name }}</h1>
<p class="lead">Edit this Confront below. <a href="{{ route('references.index') }}">Go back to all Confronts.</a></p>
<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success')

@include('partials.forms.references')

@stop
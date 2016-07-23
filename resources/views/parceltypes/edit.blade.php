@extends('layouts.master')

@section('content')

<h1>Edit Nature - {{ $data->name }}</h1>
<p class="lead">Edit this Nature below. <a href="{{ route('parceltypes.index') }}">Go back to all Natures.</a></p>
<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success')

@include('partials.forms.parceltypes')

@stop
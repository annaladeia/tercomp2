@extends('layouts.master')

@section('content')

<h1>Edit Document - {{ $data->name }}</h1>
<p class="lead">Edit this Document below. <a href="{{ route('documents.index') }}">Go back to all Documents.</a></p>
<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success')

@include('partials.forms.documents')

@stop
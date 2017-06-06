@extends('layouts.master')

@section('content')

<h1>New Document</h1>
<p class="lead">Add a new document below. <a href="{{ route('documents.index') }}">Go back to all Documents.</a></p>
<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success')

@include('partials.forms.documents')


@stop
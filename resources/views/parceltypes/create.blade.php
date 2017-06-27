@extends('layouts.master')

@section('content')

<h1>New Nature</h1>
<p class="lead">Add a new nature below. <a href="{{ route('parceltypes.index') }}">Go back to all Natures des parcelles.</a></p>
<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success')

@include('partials.forms.parceltypes')


@stop
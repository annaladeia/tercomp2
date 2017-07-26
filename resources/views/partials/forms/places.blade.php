@if(isset($data))

{!! Form::model($data, [
    'method' => 'PATCH',
    'route' => ['places.update', $data->id]
]) !!}

@else

{!! Form::open([
    'route' => 'places.store'
]) !!}

@endif

<div class="form-group">
    {!! Form::label('name', 'Nom:', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('comments', 'Autres renseigments:', ['class' => 'control-label']) !!}
    {!! Form::textarea('comments', null, ['class' => 'form-control']) !!}
</div>

<div class="pull-right">
<a href="{{ route('places.index') }}" class="btn btn-link">Back to all Entités toponymiques</a>
{!! Form::button('Save Toponyme', ['class' => 'btn btn-primary form-btn-redirect-edit']) !!}
{!! Form::submit('Save Toponyme & Add New', ['class' => 'btn btn-primary btn-success']) !!}
</div>

{!! Form::hidden('redirect', 'new') !!}

{!! Form::close() !!}
@if(isset($data))

{!! Form::model($data, [
    'method' => 'PATCH',
    'route' => ['professions.update', $data->id]
]) !!}

@else

{!! Form::open([
    'route' => 'professions.store'
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
<a href="{{ route('professions.index') }}" class="btn btn-link">Back to all Métiers</a>
{!! Form::button('Save Métier', ['class' => 'btn btn-primary form-btn-redirect-edit']) !!}
{!! Form::submit('Save Métier & Add New', ['class' => 'btn btn-primary btn-success']) !!}
</div>

{!! Form::hidden('redirect', 'new') !!}

{!! Form::close() !!}
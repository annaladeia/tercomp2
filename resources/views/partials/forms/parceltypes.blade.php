@if(isset($data))

{!! Form::model($data, [
    'method' => 'PATCH',
    'route' => ['parceltypes.update', $data->id]
]) !!}

@else

{!! Form::open([
    'route' => 'parceltypes.store'
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
<a href="{{ route('parceltypes.index') }}" class="btn btn-link">Back to all Natures des parcelles</a>
{!! Form::button('Save Nature', ['class' => 'btn btn-primary form-btn-redirect-edit']) !!}
{!! Form::submit('Save Nature & Add New', ['class' => 'btn btn-primary btn-success']) !!}
</div>

{!! Form::hidden('redirect', 'new') !!}

{!! Form::close() !!}
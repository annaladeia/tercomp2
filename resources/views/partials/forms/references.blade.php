@if(isset($data))

{!! Form::model($data, [
    'method' => 'PATCH',
    'route' => ['references.update', $data->id]
]) !!}

@else

{!! Form::open([
    'route' => 'references.store'
]) !!}

@endif

<div class="form-group">
    {!! Form::label('name', 'Nom:', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('type', 'Type:', ['class' => 'control-label']) !!}
    <div>
        <label class="radio-inline">
            {{ Form::radio('type', 1, true) }} ligne
        </label>
        <label class="radio-inline">
            {{ Form::radio('type', 2) }} point
        </label>
    </div>
</div>

<div class="form-group">
    {!! Form::label('comments', 'Autre renseigment:', ['class' => 'control-label']) !!}
    {!! Form::textarea('comments', null, ['class' => 'form-control']) !!}
</div>

<div class="pull-right">
<a href="{{ route('references.index') }}" class="btn btn-link">Back to all Confronts</a>
{!! Form::button('Save Confront', ['class' => 'btn btn-primary form-btn-redirect-edit']) !!}
{!! Form::submit('Save Confront & Add New', ['class' => 'btn btn-primary btn-success']) !!}
</div>

{!! Form::hidden('redirect', 'new') !!}

{!! Form::close() !!}
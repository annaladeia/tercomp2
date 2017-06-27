@if(isset($data))

{!! Form::model($data, [
    'method' => 'PATCH',
    'route' => ['documents.update', $data->id]
]) !!}

@else

{!! Form::open([
    'route' => 'documents.store'
]) !!}

@endif

<div class="form-group">
    {!! Form::label('name', 'Nom:', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('year', 'Year:', ['class' => 'control-label']) !!}
    {!! Form::text('year', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('type', 'Type:', ['class' => 'control-label']) !!}
    {!! Form::select('type', [1 => 'type 1', 2 => 'type 2'], isset($data) ? $data->type : 1, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('archive', 'Archive:', ['class' => 'control-label']) !!}
    {!! Form::text('archive', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('code', 'Cote:', ['class' => 'control-label']) !!}
    {!! Form::text('code', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('authors', 'Responsables:', ['class' => 'control-label']) !!}
    {!! Form::textarea('authors', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('representatives', 'Représentants:', ['class' => 'control-label']) !!}
    {!! Form::textarea('representatives', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('comments', 'Autres renseignements:', ['class' => 'control-label']) !!}
    {!! Form::textarea('comments', null, ['class' => 'form-control']) !!}
</div>

<div class="pull-right">
<a href="{{ route('documents.index') }}" class="btn btn-link">Back to all Documents</a>
{!! Form::button('Save Document', ['class' => 'btn btn-primary form-btn-redirect-edit']) !!}
</div>

{!! Form::hidden('redirect', 'new') !!}

{!! Form::close() !!}
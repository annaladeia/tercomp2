@if(isset($data))

{!! Form::model($data, [
    'method' => 'PATCH',
    'route' => ['proprietors.update', $data->id]
]) !!}

@else

{!! Form::open([
    'route' => 'proprietors.store'
]) !!}

@endif

<div class="form-group">
    {!! Form::label('name', 'Nom:', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('first_name', 'Prenom:', ['class' => 'control-label']) !!}
    {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('nickname', 'Surnom:', ['class' => 'control-label']) !!}
    {!! Form::text('nickname', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('differential', 'Discriminateur:', ['class' => 'control-label']) !!}
    {!! Form::text('differential', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group df-group df-hidden">
    {!! Form::label('related_type[]', 'Lien Familial:', ['class' => 'control-label']) !!}
    <div class="form-inline form-group df-content hide">
        <div class="form-group">
            {!! Form::select('related_type[]', $familyRelations, null, ['class' => 'form-control']) !!}
        </div>
        de
        <div class="form-group">
            {!! Form::select('related_proprietor[]', $proprietors, null, ['class' => 'df-unique form-control']) !!}
        </div>
        <button class="btn btn-danger df-delete" type="button">
            <span class="glyphicon glyphicon-minus"></span>
        </button>
    </div>
    
    <div class="df-container">
        @if(isset($data))
        @foreach ($data->relatedProprietors as $proprietor)
        <div class="form-inline form-group df-content-item">
            <div class="form-group">
                {!! Form::select('related_type[]', $familyRelations, $proprietor->family_relation_id, ['class' => 'form-control']) !!}
            </div>
            de
            <div class="form-group">
                {!! Form::select('related_proprietor[]', $proprietors, $proprietor->id, ['class' => 'df-unique form-control']) !!}
            </div>
            <button class="btn btn-danger df-delete" type="button">
                <span class="glyphicon glyphicon-minus"></span>
            </button>
        </div>
        @endforeach
        @endif
    </div>
    
    <div class="form-group">
        <button class="btn btn-success df-add" type="button">
            Add <span class="glyphicon glyphicon-plus"></span>
        </button>
    </div>
    
</div>

<div class="form-group">
    {!! Form::label('residence', 'Lieu de residence:', ['class' => 'control-label']) !!}
    {!! Form::text('residence', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('occupation', 'Métier / Statut:', ['class' => 'control-label']) !!}
    {!! Form::text('occupation', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('comments', 'Autre renseigment:', ['class' => 'control-label']) !!}
    {!! Form::textarea('comments', null, ['class' => 'form-control']) !!}
</div>

<div class="pull-right">
<a href="{{ route('proprietors.index') }}" class="btn btn-link">Back to all Propriétaires</a>
{!! Form::button('Save Propriétaire', ['class' => 'btn btn-primary form-btn-redirect-edit']) !!}
{!! Form::submit('Save Propriétaire & Add New', ['class' => 'btn btn-primary btn-success']) !!}
</div>

{!! Form::hidden('redirect', 'new') !!}

{!! Form::close() !!}
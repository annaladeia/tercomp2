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
    {!! Form::label('institution', 'Institution:', ['class' => 'control-label']) !!}
    {!! Form::text('institution', null, ['class' => 'form-control']) !!}
</div>

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
    
    {!! Form::label('sex', 'Genre:', ['class' => 'control-label']) !!}
    
    <div>
        <label class="radio-inline">
            {{ Form::radio('sex', 0, true) }} Inconnu
        </label>
        <label class="radio-inline">
            {{ Form::radio('sex', 1) }} Mâle
        </label>
        <label class="radio-inline">
            {{ Form::radio('sex', 2) }} Femelle
        </label>
    </div>
    
</div>

<div class="form-group">
    {!! Form::label('page', 'Folio:', ['class' => 'control-label']) !!}
    {!! Form::text('page', null, ['class' => 'form-control']) !!}
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
            {!! Form::select('related_connection_type[]', [1 => 'Propriétaire enregistre', 2 => 'Nouveau propriétaire'], null, ['class' => 'form-toggle form-control']) !!}
        </div>
        <div class="form-group form-toggle-option form-toggle-option-1">
            {!! Form::select('related_proprietor[]', $proprietors, null, ['class' => 'df-unique form-control form-entity']) !!}
        </div>
        <div class="form-group form-toggle-option form-toggle-option-2 hide">
            {!! Form::text('related_proprietor_name[]', null, ['class' => 'form-control', 'placeholder' => 'Nom']) !!}
            {!! Form::text('related_proprietor_first_name[]', null, ['class' => 'form-control', 'placeholder' => 'Surnom']) !!}
            {!! Form::text('related_proprietor_differential[]', null, ['class' => 'form-control', 'placeholder' => 'Discriminateur']) !!}
        </div>
        <button class="btn btn-danger df-delete" type="button">
            <span class="glyphicon glyphicon-minus"></span>
        </button>
        <a href="#" class="btn btn-link form-view-entity form-toggle-option form-toggle-option-1" data-entity-type="proprietors">View propriétaire <span class="glyphicon glyphicon-new-window"></span></a>
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
                {!! Form::select('related_connection_type[]', [1 => 'Propriétaire enregistre', 2 => 'Nouveau propriétaire'], null, ['class' => 'form-toggle form-control']) !!}
            </div>
            <div class="form-group form-toggle-option form-toggle-option-1">
                {!! Form::select('related_proprietor[]', $proprietors, $proprietor->id, ['class' => 'df-unique form-control form-entity']) !!}
            </div>
            <div class="form-group form-toggle-option form-toggle-option-2 hide">
                {!! Form::text('related_proprietor_name[]', null, ['class' => 'form-control', 'placeholder' => 'Nom']) !!}
                {!! Form::text('related_proprietor_first_name[]', null, ['class' => 'form-control', 'placeholder' => 'Surnom']) !!}
                {!! Form::text('related_proprietor_differential[]', null, ['class' => 'form-control', 'placeholder' => 'Discriminateur']) !!}
            </div>
            <button class="btn btn-danger df-delete" type="button">
                <span class="glyphicon glyphicon-minus"></span>
            </button>
            <a href="#" class="btn btn-link form-view-entity form-toggle-option form-toggle-option-1" data-entity-type="proprietors">View propriétaire <span class="glyphicon glyphicon-new-window"></span></a>
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

<div class="form-group df-group df-hidden">
    {!! Form::label('profession[]', 'Métier:', ['class' => 'control-label']) !!}
    <div class="form-inline form-group df-content hide">
        <div class="form-group">
            {!! Form::select('profession_type[]', [1 => 'Métier enregistre', 2 => 'Nouveau métier'], null, ['class' => 'form-toggle form-control']) !!}
        </div>
        <div class="form-group form-toggle-option form-toggle-option-1">
            {!! Form::select('profession[]', $professions, null, ['class' => 'df-unique form-control']) !!}
        </div>
        <div class="form-group form-toggle-option form-toggle-option-2 hide">
            {!! Form::text('profession_name[]', null, ['class' => 'form-control', 'placeholder' => 'Métier']) !!}
        </div>
        <button class="btn btn-danger df-delete" type="button">
            <span class="glyphicon glyphicon-minus"></span>
        </button>
    </div>
    
    <div class="df-container">
        @if(isset($data))
        @foreach ($data->professions as $profession)
        <div class="form-inline form-group df-content-item">
            <div class="form-group">
                {!! Form::select('profession_type[]', [1 => 'Métier enregistre', 2 => 'Nouveau métier'], null, ['class' => 'form-toggle form-control']) !!}
            </div>
            <div class="form-group form-toggle-option form-toggle-option-1">
                {!! Form::select('profession[]', $professions, $profession->id, ['class' => 'df-unique form-control form-entity']) !!}
            </div>
            <div class="form-group form-toggle-option form-toggle-option-2 hide">
                {!! Form::text('profession_name[]', null, ['class' => 'form-control', 'placeholder' => 'Métier']) !!}
            </div>
            <button class="btn btn-danger df-delete" type="button">
                <span class="glyphicon glyphicon-minus"></span>
            </button>
            <a href="#" class="btn btn-link form-view-entity form-toggle-option form-toggle-option-1" data-entity-type="professions">View métier <span class="glyphicon glyphicon-new-window"></span></a>
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
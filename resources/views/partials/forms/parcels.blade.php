@if(isset($data) AND $data->id)

{!! Form::model($data, [
    'method' => 'PATCH',
    'route' => ['parcels.update', $data->id]
]) !!}

@else

{!! Form::model($data, [
    'route' => 'parcels.store'
]) !!}

@endif


<div class="panel panel-default">
    
    <div class="panel-heading">Source</div>
    
    <div class="panel-body form-horizontal">

        <div class="form-group">
            {!! Form::label('page_number', 'Folio:', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('page_number', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                <label class="radio-inline">
                    {{ Form::radio('front', 1, true) }} recto
                </label>
                <label class="radio-inline">
                    {{ Form::radio('front', 0) }} verso
                </label>
            </div>
        </div>
        
        <div class="form-group">
            {!! Form::label('parcel_number', 'Nr. de parcelle de la page:', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('parcel_number', null, ['class' => 'form-control']) !!}
            </div>
        </div>

    </div>
    
</div>

<div class="panel panel-default">
    
    <div class="panel-heading">Propriétaire(s)</div>
    
    <div class="panel-body">

        <div class="form-group df-group @if(isset($data)) df-hidden @endif">
            
            <div class="form-inline form-group df-content hide">
                <div class="form-group">
                    {!! Form::select('proprietor[]', $proprietors, null, ['class' => 'df-unique form-control form-entity']) !!}
                </div>
                <button class="btn btn-danger df-delete" type="button">
                    <span class="glyphicon glyphicon-minus"></span>
                </button>
                <a href="#" class="btn btn-link form-view-entity" data-entity-type="proprietors">View propriétaire <span class="glyphicon glyphicon-new-window"></span></a>
            </div>
            
            <div class="df-container">
                @if(isset($data))
                @foreach ($data->proprietors as $proprietor)
                <div class="form-inline form-group df-content-item">
                    <div class="form-group">
                        {!! Form::select('proprietor[]', $proprietors, $proprietor->id, ['class' => 'df-unique form-control form-entity']) !!}
                    </div>
                    <button class="btn btn-danger df-delete" type="button">
                        <span class="glyphicon glyphicon-minus"></span>
                    </button>
                    <a href="#" class="btn btn-link form-view-entity" data-entity-type="proprietors">View propriétaire <span class="glyphicon glyphicon-new-window"></span></a>
                </div>
                @endforeach
                @endif
            </div>
            
            <div class="form-group">
                <button class="btn btn-success df-add mousetrap" data-shortcut="alt+p" type="button">
                    Add <span class="glyphicon glyphicon-plus"></span>
                </button>
                or <a href="{{ route('proprietors.create') }}" target="_blank">Create new Propriétaire <span class="glyphicon glyphicon-new-window"></span></a>
            </div>
        </div>
        
    </div>
    
</div>

<div class="panel panel-default">
    
    <div class="panel-heading">Entité(s) toponymique</div>
    
    <div class="panel-body">

        <div class="form-group df-group @if(isset($data)) df-hidden @endif">
            
            <div class="form-inline form-group df-content hide">
                <div class="form-group">
                    {!! Form::select('place[]', $places, null, ['class' => 'df-unique form-control form-entity']) !!}
                </div>
                <button class="btn btn-danger df-delete" type="button">
                    <span class="glyphicon glyphicon-minus"></span>
                </button>
                <a href="#" class="btn btn-link form-view-entity" data-entity-type="places">View toponyme <span class="glyphicon glyphicon-new-window"></span></a>
            </div>
            
            <div class="df-container">
                @if(isset($data))
                @foreach ($data->places as $place)
                <div class="form-inline form-group df-content-item">
                    <div class="form-group">
                        {!! Form::select('place[]', $places, $place->id, ['class' => 'df-unique form-control form-entity']) !!}
                    </div>
                    <button class="btn btn-danger df-delete" type="button">
                        <span class="glyphicon glyphicon-minus"></span>
                    </button>
                    <a href="#" class="btn btn-link form-view-entity" data-entity-type="places">View toponyme <span class="glyphicon glyphicon-new-window"></span></a>
                </div>
                @endforeach
                @endif
            </div>
            
            <div class="form-group">
                <button class="btn btn-success df-add mousetrap" data-shortcut="alt+t" type="button">
                    Add <span class="glyphicon glyphicon-plus"></span>
                </button>
                or <a href="{{ route('places.create') }}" target="_blank">Create new Toponyme <span class="glyphicon glyphicon-new-window"></span></a>
            </div>
        </div>
        
    </div>
    
</div>

<div class="panel panel-default">
    
    <div class="panel-heading">Nature de la parcelle</div>
    
    <div class="panel-body">

        <div class="form-group df-group @if(isset($data)) df-hidden @endif">
            
            <div class="form-inline form-group df-content hide">
                <div class="form-group">
                    {!! Form::select('parceltype[]', $parceltypes, null, ['class' => 'df-unique form-control form-entity']) !!}
                </div>
                <button class="btn btn-danger df-delete" type="button">
                    <span class="glyphicon glyphicon-minus"></span>
                </button>
                <a href="#" class="btn btn-link form-view-entity" data-entity-type="parceltypes">View nature <span class="glyphicon glyphicon-new-window"></span></a>
            </div>
            
            <div class="df-container">
                @if(isset($data))
                @foreach ($data->parceltypes as $parceltype)
                <div class="form-inline form-group df-content-item">
                    <div class="form-group">
                        {!! Form::select('parceltype[]', $parceltypes, $parceltype->id, ['class' => 'df-unique form-control form-entity']) !!}
                    </div>
                    <button class="btn btn-danger df-delete" type="button">
                        <span class="glyphicon glyphicon-minus"></span>
                    </button>
                    <a href="#" class="btn btn-link form-view-entity" data-entity-type="parceltypes">View nature <span class="glyphicon glyphicon-new-window"></span></a>
                </div>
                @endforeach
                @endif
            </div>
            
            <div class="form-group">
                <button class="btn btn-success df-add mousetrap" data-shortcut="alt+n" type="button">
                    Add <span class="glyphicon glyphicon-plus"></span>
                </button>
                <button class="btn btn-success df-prefill mousetrap" data-shortcut="alt+v" data-values="Terre,Vigne" type="button">
                    Add Terre et Vigne <span class="glyphicon glyphicon-plus"></span>
                </button>
                or <a href="{{ route('parceltypes.create') }}" target="_blank">Create new Nature <span class="glyphicon glyphicon-new-window"></span></a>
            </div>
        </div>
        
    </div>
    
</div>

<div class="panel panel-default">
    
    <div class="panel-heading">Confronts</div>
    
    <div class="panel-body">

        <div class="form-group df-group df-hidden">
            
            <div class="form-inline form-group df-content hide" data-index-start="{{count($data->parcelConnections)}}">
                <div class="form-group">
                    {!! Form::select('connection_orientation[i]', [2 => 'Levant', 3 => 'Midi', 4 => 'Couchant', 1 => 'Septentrion', 0 => 'Sans orientation'], null, ['class' => 'form-control']) !!}
                </div>
                avec
                <div class="form-group">
                    {!! Form::select('connection_type[i]', [1 => 'Propriétaire voisin', 2 => 'Confront invariant'], null, ['class' => 'form-toggle form-control']) !!}
                </div>
                <div class="form-group form-toggle-option form-toggle-option-1">
                    {!! Form::select('connection_proprietors[i][]', $proprietorsExtended, null, ['class' => 'form-control form-entity', 'multiple']) !!}
                </div>
                <div class="form-group form-toggle-option form-toggle-option-2 hide">
                    {!! Form::select('connection_reference[i]', $references, null, ['class' => 'form-control form-entity']) !!}
                </div>
                <div class="form-group">
                    {!! Form::text('connection_comments[i]', null, ['placeholder' => 'Information complémentaire', 'class' => 'form-control']) !!}
                </div>
                <label class="radio-inline">
                    {!! Form::checkbox('connection_uncertain[i]', 1) !!} Doute
                </label>
                <button class="btn btn-danger df-delete" type="button">
                    <span class="glyphicon glyphicon-minus"></span>
                </button>
                <a href="#" class="btn btn-link form-view-entity form-toggle-option form-toggle-option-1" data-entity-type="proprietors">View propriétaire <span class="glyphicon glyphicon-new-window"></span></a>
                <a href="#" class="btn btn-link form-view-entity form-toggle-option form-toggle-option-2 hide" data-entity-type="references">View confront <span class="glyphicon glyphicon-new-window"></span></a>
            </div>
            
            <div class="df-container">
                @if(isset($data))
                @foreach ($data->parcelConnections as $i => $connection)
                <div class="form-inline form-group df-content-item">
                    {!! Form::hidden('connection_id[]', $connection->id) !!}
                    <div class="form-group">
                        {!! Form::select('connection_orientation[]', [1 => 'Septentrion', 2 => 'Levant', 3 => 'Midi', 4 => 'Couchant', 0 => 'Sans orientation'], $connection->orientation, ['class' => 'form-control']) !!}
                    </div>
                    avec
                    <div class="form-group">
                        {!! Form::select('connection_type[]', [1 => 'Propriétaire voisin', 2 => 'Confront invariant'], $connection->proprietorIDs ? 1 : 2, ['class' => 'form-toggle form-control']) !!}
                    </div>
                    <div class="form-group form-toggle-option form-toggle-option-1 @if ($connection->reference_id) hide @endif">
                        {!! Form::select('connection_proprietors['.$i.'][]', $proprietorsExtended, $connection->proprietorIDs, ['class' => 'form-control form-entity', 'multiple' => 'multiple']) !!}
                    </div>
                    <div class="form-group form-toggle-option form-toggle-option-2 @if ($connection->proprietorIDs) hide @endif">
                        {!! Form::select('connection_reference[]', $references, $connection->reference_id, ['class' => 'form-control form-entity']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::text('connection_comments[]', $connection->comments, ['placeholder' => 'Information complémentaire', 'class' => 'form-control']) !!}
                    </div>
                    <label class="radio-inline">
                        {!! Form::checkbox('connection_uncertain['.$i.']', 1, $connection->uncertain) !!} Doute
                    </label>
                    <button class="btn btn-danger df-delete" type="button">
                        <span class="glyphicon glyphicon-minus"></span>
                    </button>
                    <a href="#" class="btn btn-link form-view-entity form-toggle-option form-toggle-option-1 @if ($connection->reference_id) hide @endif" data-entity-type="proprietors">View propriétaire <span class="glyphicon glyphicon-new-window"></span></a>
                    <a href="#" class="btn btn-link form-view-entity form-toggle-option form-toggle-option-2 @if ($connection->proprietorIDs) hide @endif" data-entity-type="references">View confront <span class="glyphicon glyphicon-new-window"></span></a>
                </div>
                @endforeach
                @endif
            </div>
            
            <div class="form-group">
                <button class="btn btn-success df-add mousetrap" data-shortcut="alt+c" type="button">
                    Add <span class="glyphicon glyphicon-plus"></span>
                </button>
                or <a href="{{ route('references.create') }}" target="_blank">Create new Confront invariant <span class="glyphicon glyphicon-new-window"></span></a>
                or <a href="{{ route('proprietors.create') }}" target="_blank">Create new Propriétaire <span class="glyphicon glyphicon-new-window"></span></a>
            </div>
        </div>
        
    </div>
    
</div>

<div class="panel panel-default">
    
    <div class="panel-heading">Surface</div>
    
    <div class="panel-body form-horizontal">

        <div class="form-group">
            {!! Form::label('arpent_input', 'Arpent:', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('arpent_input', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('seteree_input', 'Seteree:', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('seteree_input', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('pugnerade_input', 'Pugnerade:', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('pugnerade_input', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('coup_input', 'Coup:', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('coup_input', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('canne_input', 'Canne:', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('canne_input', null, ['class' => 'form-control']) !!}
            </div>
        </div>

    </div>
    
</div>

<div class="panel panel-default">
    
    <div class="panel-heading">Donées fiscales</div>
    
    <div class="panel-body form-horizontal">

        <div class="form-group">
            {!! Form::label('livre_input', 'Livre(s):', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('livre_input', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('sous_input', 'Sous:', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('sous_input', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('denier_input', 'Denier(s):', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('denier_input', null, ['class' => 'form-control']) !!}
            </div>
        </div>

    </div>
    
</div>

<div class="panel panel-default">
    
    <div class="panel-heading">Nouveaux Propriétaires</div>
    
    <div class="panel-body">

        <div class="form-group df-group df-hidden">
            
            <div class="form-inline form-group df-content hide" data-index-start="{{count($data->parcelMutations)}}">
                <div class="form-group">
                    {!! Form::text('mutation_month[i]', null, ['placeholder' => 'Mois', 'class' => 'form-control', 'maxlength' => 2, 'style' => 'width: 40px']) !!}
                    {!! Form::text('mutation_day[i]', null, ['placeholder' => 'Journée', 'class' => 'form-control', 'maxlength' => 2, 'style' => 'width: 40px']) !!}
                    {!! Form::text('mutation_year[i]', null, ['placeholder' => 'An', 'class' => 'form-control', 'maxlength' => 4, 'style' => 'width: 80px']) !!}
                </div>
                <div class="form-group form-toggle-option">
                    {!! Form::select('mutation_proprietors[i][]', $proprietorsExtended, null, ['class' => 'form-control form-entity', 'multiple']) !!}
                </div>
                <div class="form-group">
                    {!! Form::text('mutation_comments[i]', null, ['placeholder' => 'Commentaires', 'class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::text('mutation_share[i]', null, ['placeholder' => 'Portion', 'class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::text('mutation_reason[i]', null, ['placeholder' => 'Raison', 'class' => 'form-control']) !!}
                </div>
                <button class="btn btn-danger df-delete" type="button">
                    <span class="glyphicon glyphicon-minus"></span>
                </button>
                <a href="#" class="btn btn-link form-view-entity" data-entity-type="proprietors">View propriétaire <span class="glyphicon glyphicon-new-window"></span></a>
            </div>
            
            <div class="df-container">
                @if(isset($data))
                @foreach ($data->parcelMutations as $i => $mutation)
                <div class="form-inline form-group df-content-item">
                    {!! Form::hidden('mutation_id[]', $mutation->id) !!}
                    <div class="form-group">
                        {!! Form::text('mutation_month[]', $mutation->month, ['placeholder' => 'Mois', 'class' => 'form-control', 'maxlength' => 2, 'style' => 'width: 40px']) !!}
                        {!! Form::text('mutation_day[]', $mutation->day, ['placeholder' => 'Journée', 'class' => 'form-control', 'maxlength' => 2, 'style' => 'width: 40px']) !!}
                        {!! Form::text('mutation_year[]', $mutation->year, ['placeholder' => 'An', 'class' => 'form-control', 'maxlength' => 4, 'style' => 'width: 80px']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::select('mutation_proprietors['.$i.'][]', $proprietorsExtended, $mutation->proprietorIDs, ['class' => 'form-control form-entity', 'multiple' => 'multiple']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::text('mutation_comments[]', $mutation->comments, ['placeholder' => 'Commentaires', 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::text('mutation_share[]', $mutation->share, ['placeholder' => 'Portion', 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::text('mutation_reason[]', $mutation->reason, ['placeholder' => 'Raison', 'class' => 'form-control']) !!}
                    </div>
                    <button class="btn btn-danger df-delete" type="button">
                        <span class="glyphicon glyphicon-minus"></span>
                    </button>
                    <a href="#" class="btn btn-link form-view-entity" data-entity-type="proprietors">View propriétaire <span class="glyphicon glyphicon-new-window"></span></a>
                </div>
                @endforeach
                @endif
            </div>
            
            <div class="form-group">
                <button class="btn btn-success df-add mousetrap" data-shortcut="alt+q" type="button">
                    Add <span class="glyphicon glyphicon-plus"></span>
                </button>
                or <a href="{{ route('proprietors.create') }}" target="_blank">Create new Propriétaire <span class="glyphicon glyphicon-new-window"></span></a>
            </div>
        </div>
        
    </div>
    
</div>

<div class="form-group">
    {!! Form::label('comments', 'Autres renseigments:', ['class' => 'control-label']) !!}
    {!! Form::textarea('comments', null, ['class' => 'form-control']) !!}
</div>

<div class="pull-right">
<a href="{{ route('parcels.index') }}" class="btn btn-link">Back to all Parcelles</a>
{!! Form::button('Save Parcelle', ['class' => 'btn btn-primary form-btn-redirect-edit mousetrap', 'data-shortcut' => 'alt+s']) !!}
{!! Form::submit('... & Add New', ['class' => 'btn btn-primary btn-success mousetrap', 'data-shortcut' => 'alt+shift+s']) !!}
{!! Form::button('... New proprietor, same page', ['data-redirect' => 'new_proprietor_page', 'class' => 'btn btn-primary btn-success form-btn-redirect-edit mousetrap', 'data-shortcut' => 'alt+x']) !!}
{!! Form::button('... New proprietor, next page', ['data-redirect' => 'new_proprietor_page_plus1', 'class' => 'btn btn-primary btn-success form-btn-redirect-edit mousetrap', 'data-shortcut' => 'alt+shift+x']) !!}
{!! Form::button('... Same proprietor, same page', ['data-redirect' => 'copy_proprietor_page', 'class' => 'btn btn-warning form-btn-redirect-edit mousetrap', 'data-shortcut' => 'alt+z']) !!}
{!! Form::button('... Same proprietor, next page', ['data-redirect' => 'copy_proprietor_page_plus1', 'class' => 'btn btn-warning form-btn-redirect-edit mousetrap', 'data-shortcut' => 'alt+shift+z']) !!}
</div>

{!! Form::hidden('redirect', 'new') !!}

{!! Form::close() !!}
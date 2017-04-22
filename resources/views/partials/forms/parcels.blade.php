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
            {!! Form::label('page_number', 'Page / folio:', ['class' => 'col-sm-2 control-label']) !!}
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
                    {!! Form::select('proprietor[]', $proprietors, null, ['class' => 'df-unique form-control']) !!}
                </div>
                <button class="btn btn-danger df-delete" type="button">
                    <span class="glyphicon glyphicon-minus"></span>
                </button>
            </div>
            
            <div class="df-container">
                @if(isset($data))
                @foreach ($data->proprietors as $proprietor)
                <div class="form-inline form-group df-content-item">
                    <div class="form-group">
                        {!! Form::select('proprietor[]', $proprietors, $proprietor->id, ['class' => 'df-unique form-control']) !!}
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
                or <a href="{{ route('proprietors.create') }}" target="_blank">Create new Propriétaire</a>
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
                    {!! Form::select('place[]', $places, null, ['class' => 'df-unique form-control']) !!}
                </div>
                <button class="btn btn-danger df-delete" type="button">
                    <span class="glyphicon glyphicon-minus"></span>
                </button>
            </div>
            
            <div class="df-container">
                @if(isset($data))
                @foreach ($data->places as $place)
                <div class="form-inline form-group df-content-item">
                    <div class="form-group">
                        {!! Form::select('place[]', $places, $place->id, ['class' => 'df-unique form-control']) !!}
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
                or <a href="{{ route('places.create') }}" target="_blank">Create new Toponyme</a>
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
                    {!! Form::select('parceltype[]', $parceltypes, null, ['class' => 'df-unique form-control']) !!}
                </div>
                <button class="btn btn-danger df-delete" type="button">
                    <span class="glyphicon glyphicon-minus"></span>
                </button>
            </div>
            
            <div class="df-container">
                @if(isset($data))
                @foreach ($data->parceltypes as $parceltype)
                <div class="form-inline form-group df-content-item">
                    <div class="form-group">
                        {!! Form::select('parceltype[]', $parceltypes, $parceltype->id, ['class' => 'df-unique form-control']) !!}
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
                or <a href="{{ route('parceltypes.create') }}" target="_blank">Create new Nature</a>
            </div>
        </div>
        
    </div>
    
</div>

<div class="panel panel-default">
    
    <div class="panel-heading">Confronts</div>
    
    <div class="panel-body">

        <div class="form-group df-group df-hidden">
            
            <div class="form-inline form-group df-content hide">
                <div class="form-group">
                    {!! Form::select('connection_orientation[]', [1 => 'Septentrion', 2 => 'Levant', 3 => 'Midi', 4 => 'Couchant'], null, ['class' => 'form-control']) !!}
                </div>
                avec
                <div class="form-group">
                    {!! Form::select('connection_type[]', [1 => 'Propriétaire voisin', 2 => 'Confront invariant'], null, ['class' => 'form-toggle form-control']) !!}
                </div>
                <div class="form-group form-toggle-option form-toggle-option-1">
                    {!! Form::select('connection_proprietor[]', $proprietors, null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group form-toggle-option form-toggle-option-2 hide">
                    {!! Form::select('connection_reference[]', $references, null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::text('connection_comments[]', null, ['placeholder' => 'Information complémentaire', 'class' => 'form-control']) !!}
                </div>
                <button class="btn btn-danger df-delete" type="button">
                    <span class="glyphicon glyphicon-minus"></span>
                </button>
            </div>
            
            <div class="df-container">
                @if(isset($data))
                @foreach ($data->parcelConnections as $connection)
                <div class="form-inline form-group df-content-item">
                    {!! Form::hidden('connection_id[]', $connection->id) !!}
                    <div class="form-group">
                        {!! Form::select('connection_orientation[]', [1 => 'Septentrion', 2 => 'Levant', 3 => 'Midi', 4 => 'Couchant'], $connection->orientation, ['class' => 'form-control']) !!}
                    </div>
                    avec
                    <div class="form-group">
                        {!! Form::select('connection_type[]', [1 => 'Propriétaire voisin', 2 => 'Confront invariant'], $connection->proprietor_id ? 1 : 2, ['class' => 'form-toggle form-control']) !!}
                    </div>
                    <div class="form-group form-toggle-option form-toggle-option-1 @if ($connection->reference_id) hide @endif">
                        {!! Form::select('connection_proprietor[]', $proprietors, $connection->proprietor_id, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group form-toggle-option form-toggle-option-2 @if ($connection->proprietor_id) hide @endif">
                        {!! Form::select('connection_reference[]', $references, $connection->reference_id, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::text('connection_comments[]', $connection->comments, ['placeholder' => 'Information complémentaire', 'class' => 'form-control']) !!}
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
                or <a href="{{ route('references.create') }}" target="_blank">Create new Confront invariant</a>
            </div>
        </div>
        
    </div>
    
</div>

<div class="panel panel-default">
    
    <div class="panel-heading">Surface</div>
    
    <div class="panel-body form-horizontal">

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
            {!! Form::label('denier_input', 'Denier(s):', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('denier_input', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('sous_input', 'Sous:', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('sous_input', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('livre_input', 'Livre(s):', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('livre_input', null, ['class' => 'form-control']) !!}
            </div>
        </div>

    </div>
    
</div>

<div class="form-group">
    {!! Form::label('comments', 'Autre renseigment:', ['class' => 'control-label']) !!}
    {!! Form::textarea('comments', null, ['class' => 'form-control']) !!}
</div>

<div class="pull-right">
<a href="{{ route('parcels.index') }}" class="btn btn-link">Back to all Parcelles</a>
{!! Form::button('Save Parcelle', ['class' => 'btn btn-primary form-btn-redirect-edit']) !!}
{!! Form::submit('... & Add New', ['class' => 'btn btn-primary btn-success']) !!}
{!! Form::button('... Same proprietor, same page', ['data-redirect' => 'copy_proprietor_page', 'class' => 'btn btn-primary btn-success form-btn-redirect-edit']) !!}
{!! Form::button('... Same proprietor, next page', ['data-redirect' => 'copy_proprietor_page_plus1', 'class' => 'btn btn-primary btn-success form-btn-redirect-edit']) !!}
</div>

{!! Form::hidden('redirect', 'new') !!}

{!! Form::close() !!}
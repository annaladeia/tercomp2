<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="{{ route('home') }}">Tercomp</a>
      <div class="pull-left">
        {!! Form::select('documents', $documents, $documentID, ['class' => 'form-control form-trigger-change', 'data-trigger-change-url' => route('changeActiveDocument')]) !!}
      </div>
    </div>
    <ul class="nav navbar-nav navbar-right">
      <li {{{ (Request::is('documents') || Request::is('documents/*') ? 'class=active' : '') }}}><a href="{{ route('documents.index') }}">Documents</a></li>
        <li {{{ (Request::is('parcels') || Request::is('parcels/*') ? 'class=active' : '') }}}><a href="{{ route('parcels.index') }}">Parcelles</a></li>
        <li {{{ (Request::is('proprietors') || Request::is('proprietors/*') ? 'class=active' : '') }}}><a href="{{ route('proprietors.index') }}">Propriétaires</a></li>
        <li {{{ (Request::is('places') || Request::is('places/*') ? 'class=active' : '') }}}><a href="{{ route('places.index') }}">Toponymes</a></li>
        <li {{{ (Request::is('references') || Request::is('references/*') ? 'class=active' : '') }}}><a href="{{ route('references.index') }}">Confronts</a></li>
        <li {{{ (Request::is('parceltypes') || Request::is('parceltypes/*') ? 'class=active' : '') }}}><a href="{{ route('parceltypes.index') }}">Natures</a></li>
        <li {{{ (Request::is('professions') || Request::is('professions/*') ? 'class=active' : '') }}}><a href="{{ route('professions.index') }}">Métiers</a></li>
    </ul>
  </div>
</nav>
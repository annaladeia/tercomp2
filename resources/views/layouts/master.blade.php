<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tercomp</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
<link href="/assets/css/select2-bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="{{ route('home') }}">Tercomp</a>
    </div>
    <div class="nav navbar-nav navbar-right">
        <li {{{ (Request::is('proprietors') || Request::is('proprietors/*') ? 'class=active' : '') }}}><a href="{{ route('proprietors.index') }}">Propriétaires</a></li>
        <li {{{ (Request::is('parcels') || Request::is('parcels/*') ? 'class=active' : '') }}}><a href="{{ route('parcels.index') }}">Parcelles</a></li>
        <li {{{ (Request::is('places') || Request::is('places/*') ? 'class=active' : '') }}}><a href="{{ route('places.index') }}">Toponymes</a></li>
    </div>
  </div>
</nav>

<main>
    <div class="container">
        @yield('content')
    </div>
</main>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
<script src="/assets/js/select2.js"></script>
<script src="/assets/js/dynamic-forms.js"></script>
<script src="/assets/js/forms.js"></script>

</body>
</html>
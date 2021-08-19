<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">
<head> 
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS -->
  <link 
    rel="stylesheet" 
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" 
    integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" 
    crossorigin="anonymous"
  >

  {!! 
    // renders avaialble plugins that should renders in the header
    collect($plugins)->filter->asMetadata()->map->render()->implode('') 
  !!}  
</head>
<body 
  data-component="{{ data_get($component, 'uriKey') }}"  
  data-fragment="@isset($fragment){{ data_get($fragment, 'uriKey') }}@endisset" 
> 
  {!! 
    // renders avaialble widgets
    $widgets 
  !!} 
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" 
    crossorigin="anonymous"
  ></script>
  {!! 
    // renders avaialble plugins that should render in the footer
    collect($plugins)->reject->asMetadata()->map->render()->implode('') 
  !!} 
</body>
</html>
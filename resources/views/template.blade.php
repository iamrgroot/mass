<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="/images/logo.svg">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="/vue/css/chunk-vuetify.css">
    <link rel="stylesheet" href="/vue/css/chunk-{{ $name }}-vendors.css">
    <link rel="stylesheet" href="/vue/css/{{ $name }}.css">

    <title>😀</title>
  </head>
  <body>
    <noscript>
      <strong>We're sorry but frontend doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
    </noscript>
    <div id="app"></div>

    <script>
      window.blade_errors = {!! json_encode($errors->all() ?? []) !!};
      @if(isset($inject))
          window.injected = {!! json_encode($inject) !!};
      @endif
    </script>

    <script src="/vue/js/chunk-vuetify.js"></script>
    <script src="/vue/js/chunk-common.js"></script>
    <script src="/vue/js/chunk-{{ $name }}-vendors.js"></script>
    <script src="/vue/js/{{ $name }}.js"></script>
  </body>
</html>
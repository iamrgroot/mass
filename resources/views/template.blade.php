<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="/images/logo.svg">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="/vue/css/chunk-vendors.css">
    <link rel="stylesheet" href="/vue/css/{{ $name }}.css">

    <title>😀</title>
  </head>
  <body>
    <noscript>
      <strong>We're sorry but frontend doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
    </noscript>
    <div id="app"></div>

    @if(isset($chunk))
      <script src="/vue/js/chunk-{{ $chunk }}-vendors.js"></script>
    @endif
    <script src="/vue/js/chunk-vendors.js"></script>
    <script src="/vue/js/chunk-common.js"></script>
    <script src="/vue/js/{{ $name }}.js"></script>
  </body>
</html>
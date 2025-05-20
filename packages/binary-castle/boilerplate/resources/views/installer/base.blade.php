<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Installer - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('vendor/boilerplate/css/bootstrap.css')  }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="container">
<div style="padding-top: 10vh">
    <x-installer-timeline/>
</div>

@yield('content')

<script src="{{asset('vendor/boilerplate/js/bootstrap.bundle.js')}}"></script>
</body>
</html>

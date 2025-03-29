<!doctype html>
<html lang="en">
    <head>
        <title>@yield('title')</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <link rel="stylesheet" href="{{ asset('assets/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.7.2-web/css/all.min.css') }}">

        <script src="{{ asset('assets/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/popper.min.js') }}"></script>
        <style>
            body {
                background-color: rgb(59, 59, 59);
                color:white;
            }
        </style>
    </head>

    <body>
        @include('alerts.alert')
        @yield('content')
        @include('../components/footer')
    </body>
</html>

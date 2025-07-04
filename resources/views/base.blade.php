<!doctype html>
<html lang="en">
    <head>
        <title  >@yield('title')</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <link rel="stylesheet" href="{{ asset('assets/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.7.2-web/css/all.min.css') }}">

        <script src="{{ asset('assets/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/popper.min.js') }}"></script>
        <style>
            body {
                /* background-color: rgb(59, 59, 59); */
                background-repeat: no-repeat;
                background-size: cover; /* Faz a imagem cobrir toda a área */
                background-position: center center; /* Centraliza a imagem */
                background-attachment: fixed; 
                background-image: url({{ asset('assets/images/space_photo2.jpg') }});
            }
            .wLenghtHome {
                width: 68%;
            }
            .headerMain {
                background-color: rgb(59, 59, 59);
            }
            .bg-transparent {
                background-color: transparent;
            }
            .optionsCategory:hover {
                border: 1px solid white;
            }
            .input-transparent {
                background-color: transparent;
                color: white;
                border: 1px solid white;
            }
            .select-transparent {
                background-color: transparent !important; 
                border: 1px solid white; 
                color: white; 
                -webkit-appearance: none; 
                -moz-appearance: none;
                appearance: none;
            }
            
            .select-transparent option {
                background-color: rgb(0, 0, 0); 
                color: white;
            }
        </style>
    </head>

    <body>
        @include('alerts.alert')
        @yield('content')
        @include('../components/footer')
    </body>
</html>

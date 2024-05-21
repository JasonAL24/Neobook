<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Neobook | {{$title}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--    Styles   --}}
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/css/navbar.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/css/search.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/css/home.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/css/bookdetails.css') }}" type="text/css">

    {{--    BootStrap (5.3.3)  --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{--    Fonts using Gentium Book Basic --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Gentium+Book+Basic&display=swap">

    {{--    Font Awesome --}}
    <script src="https://kit.fontawesome.com/9fee3de70f.js" crossorigin="anonymous"></script>

    {{--    JQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>--}}

    {{--    PDFViewer --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <style>
        body{
            font-family: 'Gentium Book Basic', serif;
            background-color: {{$title == 'Home' ? '' : '#F0EEE2'}};
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row justify-content-start">
        <div class="col-lg-1 bg-color-grey">
            @include('partials.navbar')
        </div>
        <div class="col-lg-11" style="padding: 0">
            <main role="main">
                <div class="bg-color-grey" style="width: {{ ($title === "Home") ? '50vw' : '' }}">
                    @include('partials.search')
                </div>
                <div>
                    @include('partials.notification')
                </div>
                <div>
                    @yield('container')
                </div>
            </main>
        </div>
    </div>
</div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

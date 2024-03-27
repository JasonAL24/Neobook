<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Neobook | {{$title}}</title>

    {{--    Styles   --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/search.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}" type="text/css">

    {{--    BootStrap (5.3.3)  --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <div class="d-flex flex-row">
        <div class="bg-color-grey">
            @include('partials.navbar')
        </div>
        <div>
            <main role="main">
                @include('partials.search')
                @yield('container')
            </main>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

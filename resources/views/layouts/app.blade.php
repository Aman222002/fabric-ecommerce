<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}  @yield('title')</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">



    @section('scripts')
    @parent
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize"
        async defer></script>
    <script src="/js/mapInput.js"></script>
    @stop
    <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key={AIzaSyB6E8Zp9ZTTovGtmiumT9KWneM13zxNjAw}">
    </script> -->

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <v-app>
            <header-component></header-component>
            <v-main> 
                @yield('content')
            </v-main>
            <companyfooter-component></companyfooter-component>
        </v-app>
    </div>
</body>

</html>
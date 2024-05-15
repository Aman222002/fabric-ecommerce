<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <meta name="csrf-token" content="{{ csrf_token() }}">
	 <title>{{ config('app.name', 'Laravel') }} / @yield('title')</title>
   

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

   
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
    <v-app>
       <companynav-component></companynav-component>
     
        <v-main>
            <v-container fluid>
            @yield('content')
            </v-container fluid>
        </v-main>
        <!-- <companyfooter-component></companyfooter-component> -->
       </v-app>
    </div> 
</body>
</html>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->


    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">


    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <v-app>
            <navbar-component></navbar-component>
            <sidebar-component></sidebar-component>
              <main class="main">
            @yield('content')
        </main>
        </v-app>
    </div>
</body>
<style>
    .main {
        margin-top: 57px;
        margin-left: 180px;
    }
</style>
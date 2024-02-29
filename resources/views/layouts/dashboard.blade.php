<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->


   @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <v-app>
            <navbar-component></navbar-component>
              <v-main class="p-16">
                <v-container fluid>
            @yield('content')
                </v-container fluid>
        </v-main>
        </v-app>
    </div>
</body>
<style>
</style>
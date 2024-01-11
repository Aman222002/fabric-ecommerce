<!doctype html>
<html>

<head>
    @include('includes.head')
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <header class="fixed-top">
            <header-component></header-component>
        </header>
        <div id="main" class="row">
            @yield('content')
        </div>
        <footer class="fixed-bottom">
            <footer-component></footer-component>
        </footer>
    </div>
</body>
<style>
    #main {
        margin-top: 100px;
    }
</style>

</html>
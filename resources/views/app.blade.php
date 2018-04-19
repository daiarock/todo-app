<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Todo App</title>
        <link rel="stylesheet" href="/css/app.css">
        <script type="text/javascript">
            window.Laravel = window.Laravel || {};
            window.Laravel.csrfToken = "{{csrf_token()}}";
        </script>
    </head>
    <body>
        <header class="text-center">
            <h1>Todo App</h1>
        </header>
        <main>
            <div id="app">
                <router-view></router-view>
            </div>
        </main>
        <footer class="footer">
            <p class="text-center">&copy; {{ date('Y') }} Todo App.</p>
        </footer>
        <script src="/js/app.js"></script>
    </body>
</html>
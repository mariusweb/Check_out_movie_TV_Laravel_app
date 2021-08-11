<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta name="theme-color" content="#6777ef"/>
        <link rel="apple-touch-icon" href="{{ asset('/images/path/image2.png') }}">
        <link rel="manifest" href="{{ asset('/manifest.json') }}">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">


    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <!-- Scripts -->
        <footer class="py-5 bg-dark">
            <div class="container">
                <div class="d-flex justify-content-between">
                    <p class="m-0 text-center text-white">Copyright &copy; Your Website 2021</p>
                    <div class="d-flex">
                        <p class="m-0 text-center text-white">Movies and TV-shows are from </p>
                        <a class="w-25 d-flex align-content-center pl-1" href="https://www.themoviedb.org/">
                            <img class="w-100" src="https://www.themoviedb.org/assets/2/v4/logos/v2/blue_long_1-8ba2ac31f354005783fab473602c34c3f4fd207150182061e425d366e4f34596.svg" alt="THE MOVIE DB" />
                        </a>

                    </div>
                </div>


            </div>
        </footer>

        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/bootstrap.js') }}" defer></script>
        @yield('scripts')
        <script src="{{ asset('/sw.js') }}"></script>
        <script>
            if (!navigator.serviceWorker.controller) {
                navigator.serviceWorker.register("/sw.js").then(function (reg) {
                    console.log("Service worker has been registered for scope: " + reg.scope);
                });
            }
        </script>
    </body>
</html>

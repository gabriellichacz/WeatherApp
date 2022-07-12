<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Weather App">
    <meta name="author" content="Gabriel Lichacz">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Webpage Title -->
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Font Awesome icons -->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Bootstrap 5 -->
    <link href="/css/styles.css" rel="stylesheet" />
    <script src="/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Favicon  -->
    <link rel="icon" href="#">
</head>

<body>
    <div id="app" class="bg-dark-custom">

        <!-- navigation -->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand text-white-50" href="/"> {{ __('Pogoda') }} </a>
                <button class="navbar-toggler navbar-toggler-right text-white-50" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    {{ __('Menu') }}
                    <i class="fas fa-bars text-white-50"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <!-- Links -->
                        <li class="nav-item"><a class="nav-link text-white-50" href="/home"> Home </a></li>
                        <!-- end of Links -->
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-white-50" href="{{ route('login') }}">{{ __('Zaloguj się') }}</a>
                                </li>
                            @endif
                            
                            <!--@if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white-50" href="{{ route('register') }}">{{ __('Zarejestruj się') }}</a>
                                </li>
                            @endif-->
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white-50" href="#" role="button" 
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end text-white-50 bg-dark-custom" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item text-white-50 bg-dark-custom" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Wyloguj się') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                        <!-- end of Authentication Links -->
                    </ul>
                </div>
            </div>
        </nav>
        <!-- end of navigation -->

        <!-- Masthead-->
        <header class="masthead">
            <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
                <div class="d-flex justify-content-center">
                    <div class="text-center">
                        <h1 class="mx-auto my-0 text-uppercase"> {{ __('Pogoda') }} </h1>
                    </div>
                </div>
            </div>
        </header>
        <!-- end of Masthead -->

        <!-- Main -->
        <main class="py-4">
            @yield('content')
        </main>
        <!-- end of Main -->

        <!-- Footer-->
        <footer class="footer bg-black small text-center text-white-50">
            <div class="container px-4 px-lg-5">
                <p class="p-small"> @<?php echo date("Y"); ?> </p>
            </div>
        </footer>
        <!-- end of Footer-->

    </div>
</body>
</html>

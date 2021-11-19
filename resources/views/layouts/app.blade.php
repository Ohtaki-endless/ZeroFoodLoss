<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-social.css') }}" rel="stylesheet">
    
    
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <div class="d-flex align-items-center">
                                <li class="nav-item">
                                    <a class="btn btn-link px-3 me-2" href="{{ route('login') }}">
                                        {{ __('Login') }}
                                    </a>
                                </li>
                                @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="btn btn-primary me-3" href="{{ route('register') }}">
                                        {{ __('Register') }}
                                    </a>
                                </li>
                                @endif
                            </div>
                        @else
                              <!-- カート -->
                                <a class="nav-link btn-default" href="/cartindex">
                                    <i class="fas fa-shopping-cart fa-lg"></i>
                                    @if(session('cartData'))
                                    <span class="badge badge-danger rounded-pill badge-dot badge-notify">
                                        {{ count(session('cartData')) }}
                                    </span>
                                    @endif
                                </a>
                            
                            
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                    <li>
                                        <a class="dropdown-item" href="/user/index">マイページ</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('ログアウト') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        
    <!-- Footer -->
    <footer class="text-center text-lg-start bg-light text-muted">

        <!-- Section: Links  -->
        <section class="border-top">
            <div class="container text-center text-md-start mt-3">
                <!-- Grid row -->
                
                    <!-- Grid column -->
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                      <!-- Links -->
                      <h6 class="text-uppercase fw-bold mb-4">
                        お問い合わせ
                      </h6>
                      <p>
                        <i class="fas fa-home me-3"></i> 
                        新潟県村上市
                      </p>
                      <p>
                        <i class="fas fa-envelope me-3"></i>
                        zerofood-loss@yahoo.co.jp
                      </p>
                    </div>
                    <!-- Grid column -->
                
            <!-- Grid row -->
            </div>
        </section>
        <!-- Section: Links  -->

        <!-- Copyright -->
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2021 Copyright : {{ config('app.name') }}
        </div>
        <!-- Copyright -->
        
    </footer>
    <!-- Footer -->
    </div>
</body>
</html>

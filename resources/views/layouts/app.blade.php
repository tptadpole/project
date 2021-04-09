<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand text-muted" href="{{ url('/') }}">
                    <span data-feather="home"></span>104電商
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="navbar-brand text-primary" href="{{ url('/customer') }}">
                                <span data-feather="shopping-bag"></span>{{ __('我要去購物') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="navbar-brand text-primary" href="{{ url('/seller') }}">
                                <span data-feather="dollar-sign"></span>{{ __('我要賣商品') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="navbar-brand text-primary" href="{{ url('/') }}">
                                <span data-feather="shopping-cart"></span>{{ __('檢查購物車') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="navbar-brand text-primary" href="{{ url('/') }}">
                                <span data-feather="credit-card"></span>{{ __('結帳') }}
                            </a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>會員 : 
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('登出') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ url('/customer') }}">
                                        {{ __('我要去購物') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ url('/seller') }}">
                                        {{ __('我要賣商品') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ url('/') }}">
                                        {{ __('檢查購物車') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ url('/') }}">
                                        {{ __('結帳') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <!-- Icons -->
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
        feather.replace()
        </script>

    </div>
</body>
</html>

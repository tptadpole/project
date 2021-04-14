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

<div class="container">
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <a class="navbar-brand" href="/admin">
      <span data-feather="eye"></span>Admin後台
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="/admin/users">
            <span data-feather="users"></span>會員
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/admin/spu">
            <span data-feather="shopping-bag"></span>商品標題
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/admin/sku">
            <span data-feather="list"></span>商品
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/admin/cart">
            <span data-feather="shopping-cart"></span>購物車
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/admin/order">
            <span data-feather="book-open"></span>訂單
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/admin/orderItem/index">
            <span data-feather="book-open"></span>訂單項目
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/admin/orderItem/show">
            <span data-feather="truck"></span>運送中訂單
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/">
            <span data-feather="home"></span>返回一般版
          </a>
        </li>
      </ul>
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


</html>


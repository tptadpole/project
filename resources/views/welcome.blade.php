@extends('layouts.app')
 
@section('content')
    <div class="container">
        首頁
        @can('admin')
            <p>Hello ~ 系統管理者</p>
        @elsecan('manager')
            <p>一般管理者</p>
        @elsecan('user')
            <p>一般使用者</p>
        @else
            <p>遊客</p>
        @endcan

        <div class="row row-cols-1 row-cols-md-4">
            @foreach( $homepageProducts as $homepageProduct ) 
            <div class="col mb-4">
              <div class="card h-100">
                <svg class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#6c757d"></rect><text x="50%" y="50%" fill="#dee2e6" dy=".3em">Image cap</text></svg>
                <div class="card-body">
                  <h5 class="card-title">{{$homepageProduct->name}}</h5>
                  <p class="card-text">{{$homepageProduct->description}}</p>
                  <a href="/customer/{{$homepageProduct->id}}" class="btn btn-primary">查看更多</a>
                </div>
              </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
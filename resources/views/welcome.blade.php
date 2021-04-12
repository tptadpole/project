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
                <img src="{{asset('/images'). "/" . $homepageProduct['image']}}"  width="250px;" height="250px;" >
                <div class="card-body">
                  <h5 class="card-title">{{$homepageProduct['name']}}</h5>
                  <p class="card-text">{{$homepageProduct['description']}}</p>
                  <a href="/customer/{{$homepageProduct['id']}}" class="btn btn-primary">查看更多</a>
                </div>
              </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
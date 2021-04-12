@extends('layouts.app')

@section('content')
<div class="container">
    @can('admin')
      <h3>歡迎回來: {{ Auth::user()->name }} 目前的商品總共有{{$commodities->total()}}項</h3>
    @elsecan('manager')
      <h3>歡迎回來: {{ Auth::user()->name }} 目前的商品總共有{{$commodities->total()}}項</h3>
    @elsecan('user')
      <h3>歡迎回來: {{ Auth::user()->name }} 目前的商品總共有{{$commodities->total()}}項</h3>
    @else
      <h3>您好遊客: 目前的商品總共有{{$commodities->total()}}項</h3>
    @endcan
    <div class="row row-cols-1 row-cols-md-4">
        @foreach( $commodities as $commodity ) 
        <div class="col mb-4">
          <div class="card h-100">
            <img src="{{asset('/images'). "/" . $commodity['image']}}"  width="250px;" height="250px;" >
            <div class="card-body">
              <h5 class="card-title">{{$commodity['name']}}</h5>
              <p class="card-text">{{$commodity['description']}}</p>
              <a href="/customer/{{$commodity->id}}" class="btn btn-primary">查看更多</a>
            </div>
          </div>
        </div>
        @endforeach
    </div>
    {!! $commodities->links() !!}
</div>
@endsection
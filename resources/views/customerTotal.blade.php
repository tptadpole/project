@extends('layouts.app')

@section('content')
<div class="container">
    @can('admin')
      <h3>歡迎回來: {{ Auth::user()->name }} 目前的商品總共有{{$commodities->total()}}項</h3>
    @elsecan('manager')
      <h3>歡迎回來: {{ Auth::user()->name }} 目前的商品總共有{{$commodities->total()}}項</h3>
    @elsecan('manager')
      <h3>歡迎回來: {{ Auth::user()->name }} 目前的商品總共有{{$commodities->total()}}項</h3>
    @else
      <h3>您好遊客: 目前的商品總共有{{$commodities->total()}}項</h3>
    @endcan
    <div class="row row-cols-1 row-cols-md-4">
        @foreach( $commodities as $commodity ) 
        <div class="col mb-4">
          <div class="card h-100">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#6c757d"></rect><text x="50%" y="50%" fill="#dee2e6" dy=".3em">Image cap</text></svg>
            <div class="card-body">
              <h5 class="card-title">{{$commodity->name}}</h5>
              <p class="card-text">{{$commodity->description}}</p>
              <a href="/customer/{{$commodity->id}}" class="btn btn-primary">查看更多</a>
            </div>
          </div>
        </div>
        @endforeach
    </div>
    {!! $commodities->links() !!}
</div>
@endsection
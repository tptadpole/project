@extends('layouts.app')

@section('content')
<div class="container">
    @can('admin')
      <h3>歡迎回來: {{ Auth::user()->name }} 目前的商品總共有{{$commodities->total()}}種</h3>
    @elsecan('manager')
      <h3>歡迎回來: {{ Auth::user()->name }} 目前的商品總共有{{$commodities->total()}}種</h3>
    @elsecan('user')
      <h3>歡迎回來: {{ Auth::user()->name }} 目前的商品總共有{{$commodities->total()}}種</h3>
    @else
      <h3>您好遊客: 目前的商品總共有{{$commodities->total()}}種</h3>
    @endcan
    <div class="row row-cols-1 row-cols-md-4">
        @foreach( $commodities as $commodity ) 
        <div class="col mb-4">
          <div class="card h-100">
            <img src="{{asset('/images'). "/" . $commodity['image']}}"  width="250px;" height="250px;" >
            <div class="card-body">
              <h2 class="text-title">{{$commodity['name']}}</h2>
              <h5 class="text-info">規格: {{$commodity['specification']}}</h5>
              <h4 class="text-danger">價格: {{$commodity['price']}}</h4>
              <p class="card-text">剩餘存貨: {{$commodity['stock']}}</p>
            </div>
            <div class="card-footer">
              <form method="post" action="/cart/{{ $commodity['id'] }}/store">
                <div class="form-group">
                  @csrf
                  <label for="amount">數量:</label>
                  <input type="number" class="form-control form-control-lg text-center" name="amount" value="1" min="1" max="{{$commodity->stock}}">
                </div>
                <button type="submit" class="btn btn-success">加入購物車</button>             
              </form>
            </div>
          </div>
        </div>
        @endforeach
    </div>
    {!! $commodities->links() !!}
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h3>歡迎回來: {{ Auth::user()->name }} 你所選的商品總共有{{$commodities->total()}}種</h3>
    <div class="row row-cols-1 row-cols-md-4">
        @foreach( $commodities as $commodity ) 
        <div class="col mb-4">
          <div class="card h-100">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#6c757d"></rect><text x="50%" y="50%" fill="#dee2e6" dy=".3em">Image cap</text></svg>
            <div class="card-body">
              <h2 class="text-title">{{$commodity->name}}</h2>
              <h5 class="text-info">單瓶容量: {{$commodity->capacity}}ml</h5>
              <h4 class="text-danger">價格: {{$commodity->price}}</h4>
              <p class="card-text">剩餘存貨: {{$commodity->stock}}</p>
            </div>
            <div class="card-footer">
                <a href="#" class="btn btn-light">加入購物車</a>
                <a href="#" class="btn btn-primary">直接購買</a>
            </div>
          </div>
        </div>
        @endforeach
    </div>
    {!! $commodities->links() !!}
</div>
@endsection
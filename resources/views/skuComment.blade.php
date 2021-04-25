@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row row-cols-1 row-cols-md-4">
        <div class="col mb-4">
            <div class="card h-100">
            @if($sku[0]['image'])
                <img src="https://104-aws-training-cicd-bucket.s3-ap-northeast-1.amazonaws.com/garyke/garyke-demo/image/{{$sku[0]['image']}} "width="250px;" height="250px;" />
            @endif
            <div class="card-body">
                <h2 class="text-title">{{$sku[0]['name']}}</h2>
                <h5 class="text-info">規格: {{$sku[0]['specification']}}</h5>
                <h4 class="text-danger">價格: {{$sku[0]['price']}}</h4>
                <p class="card-text">剩餘存貨: {{$sku[0]['stock']}}</p>
            </div>
            <div class="card-footer">
                <form method="post" action="/cart/{{ $sku[0]['id'] }}/store">
                    <div class="form-group">
                        @csrf
                        <label for="amount">數量:</label>
                        <input type="number" class="form-control form-control-lg text-center" name="amount" value="1" min="1" max="{{$sku[0]['stock']}}">
                    </div> 
                    <button type="submit" class="btn btn-success">加入購物車</button>             
                </form>
            </div>
        </div>
    </div>
    <div class="card" style="width: 18rem;">
        <div class="card-header">
          評論
        </div>
        <ul class="list-group list-group-flush">
            @foreach ($comments as $comment)
                <li class="list-group-item">{{$comment['comment']}}</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
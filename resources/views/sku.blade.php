@extends('layouts.app')

@section('content')
<div class="container">
    <h3>歡迎回來: {{ Auth::user()->name }} 你目前所販賣的{{$spu[0]['name']}}總共有{{count($commodities)}}種</h3>
    <div class="card w-100">
        <svg class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#6c757d"></rect><text x="50%" y="50%" fill="#dee2e6" dy=".3em">Image cap</text></svg>
        <div class="card-body">
            <h5 class="card-title">{{$spu[0]['name']}}</h5>
            <p class="card-text">{{$spu[0]['description']}}</p>
        </div>
        <div class="card-footer">
            <a href="/seller/{{ $spu[0]['id'] }}/edit" class="btn btn-primary">修改</a>
            <form action="/seller/{{ $spu[0]['id'] }}/destroy" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <div class="form-group">
                    <input type="submit" class="btn btn-danger" value="刪除">
                </div>
            </form>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-md-4">
    @foreach( $commodities as $commodity )
        <div class="col mb-4">
            <div class="card h-100">
                <svg class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#6c757d"></rect><text x="50%" y="50%" fill="#dee2e6" dy=".3em">Image cap</text></svg>
                <div class="card-body">
                    <h2 class="card-title">{{$commodity['name']}}</h2>
                    <h5 class="text-info">{{$spu[0]['name']}}單瓶容量:{{$commodity['capacity']}}ml</h5>
                    <h4 class="text-danger">價格:{{$commodity['price']}}</h4>
                    <div class="card-footer">
                        <h5 class="text-muted">剩餘存貨:{{$commodity['stock']}}</h5>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="/seller/commodity/{{ $commodity['id'] }}/edit" class="btn btn-primary">修改</a>
                    <form action="/seller/commodity/{{ $commodity['id'] }}/destroy" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <div class="form-group">
                            <input type="submit" class="btn btn-danger" value="刪除">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    </div>
    <div class="card text-center">
        <div class="card-body">
            <h5 class="card-title">要賣新的種類嗎?</h5>
            <p class="card-text">歡迎你使用104電商來販售物品,用過的都說讚</p>
            <a href="/seller/commodity/{{$spu[0]['id']}}/create" class="btn btn-success">新增商品種類</a>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h3>歡迎回來: {{ Auth::user()->name }} 你目前所販賣的{{$spu[0]['name']}}總共有{{count($commodities)}}種</h3>
    <div class="card w-100">
        <div class="card-body">
            <h5 class="card-title">{{$spu[0]['name']}}</h5>
            <p class="card-text">{{$spu[0]['description']}}</p>
            <a href="#" class="btn btn-primary">修改</a>
            <a href="#" class="btn btn-danger">刪除</a>
        </div>
    </div>
    @foreach( $commodities as $commodity )
        <div class="card w-100">
            <div class="card-body">
                <h5 class="card-title">{{$spu[0]['name']}}容量:{{$commodity['capacity']}}ml</h5>
                <h4 class="card-text">價格:{{$commodity['price']}}</h4>
                <div class="card-footer">
                    <h5 class="text-muted">剩餘存貨:{{$commodity['stock']}}</h5>
                  </div>
                <a href="#" class="btn btn-primary">修改</a>
                <form action="/seller/commodity/{{ $commodity['id'] }}/destroy" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <div class="form-group">
                        <input type="submit" class="btn btn-danger" value="刪除">
                    </div>
                    {{-- <a href="" class="btn btn-danger">刪除</a> --}}
                </form>
            
                {{-- <a href="/seller/{{$commodity['id']}}/destroy" class="btn btn-danger">刪除</a> --}}
            </div>
        </div>
    @endforeach
    <div class="card text-center">
        <div class="card-body">
            <h5 class="card-title">要賣新的種類嗎?</h5>
            <p class="card-text">歡迎你使用104電商來販售物品,用過的都說讚</p>
            <a href="/seller/commodity/{{$spu[0]['id']}}/create" class="btn btn-success">新增商品種類</a>
        </div>
    </div>
</div>
@endsection
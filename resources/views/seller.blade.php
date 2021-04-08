@extends('layouts.app')

@section('content')
<div class="container">
    <h3>歡迎回來: {{ Auth::user()->name }} 你目前所販賣的商品總共有{{count($commodities)}}項</h3>
    @foreach( $commodities as $commodity )
        <div class="card w-100">
            <div class="card-body">
                <h5 class="card-title">{{$commodity['name']}}</h5>
                <p class="card-text">{{$commodity['description']}}</p>
                <a href="/seller/{{$commodity['id']}}" class="btn btn-primary">查看更多</a>
                <a href="#" class="btn btn-danger">刪除</a>
            </div>
        </div>
    @endforeach
    <div class="card text-center">
        <div class="card-body">
            <h5 class="card-title">要賣新的商品嗎?</h5>
            <p class="card-text">歡迎你使用104電商來販售物品,用過的都說讚</p>
            <a href="/seller/create" class="btn btn-success">新增商品</a>
        </div>
    </div>
</div>
@endsection
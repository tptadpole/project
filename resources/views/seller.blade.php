@extends('layouts.app')

@section('content')
<div class="container">
    <h3>歡迎回來: {{ Auth::user()->name }} 你目前所販賣的商品總共有{{count($commodities)}}項</h3>
    <div class="row row-cols-1 row-cols-md-4">
    @foreach( $commodities as $commodity )
    <div class="col mb-4">
        <div class="card h-100">
            <img src="{{asset('/images'). "/" . $commodity['image']}}"  width="250px;" height="250px;" >
            <div class="card-body">
                <h5 class="card-title">{{$commodity['name']}}</h5>
                <p class="card-text">{{$commodity['description']}}</p>
            </div>
            <div class="card-footer">
                <a href="/seller/commodity/{{$commodity['id']}}" class="btn btn-primary">查看更多</a>
                <form action="/seller/{{ $commodity['id'] }}/destroy" method="POST">
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
            <h5 class="card-title">要賣新的商品嗎?</h5>
            <p class="card-text">歡迎你使用104電商來販售物品,用過的都說讚</p>
            <a href="/seller/create" class="btn btn-success">新增商品</a>
        </div>
    </div>
    {!! $commodities->links() !!}
</div>
@endsection
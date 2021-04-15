@extends('layouts.app')

@section('content')
<style>
    .uper {
      margin-top: 40px;
    }
</style>
<div class="container">
    <div class="card uper">
        <div class="card-header">
        編輯商品名稱或描述
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div><br/>
            @endif
            <form method="post" action="/seller/{{$data['id']}}/update" enctype="multipart/form-data" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group">
                    @csrf
                    <label for="name">商品標題 :</label>
                    <input type="text" class="form-control" name="name" value="{{$data['name']}}"/>
                </div>
                <div class="form-group">
                    <label for="description">商品敘述 :</label>
                    <input type="text" class="form-control" name="description" value="{{$data['description']}}"/>
                </div>
                <div class="form-group">
                    <label for="image">商品圖片 :</label>
                    <input type="file" class="form-control" name="image"/>
                </div>
                <button type="submit" class="btn btn-success">確定編輯</button>
                <a href="/seller/commodity/{{$data['id']}}" class="btn btn-light">取消</a>
            </form>
        </div>
    </div>
</div>
@endsection
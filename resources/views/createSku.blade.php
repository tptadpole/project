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
        新增商品細項資料
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
            <form method="post" action="/seller/commodity/{{ $spu_id }}/store" enctype="multipart/form-data" autocomplete="off">
                <div class="form-group">
                    @csrf
                    <label for="name">商品名稱:</label>
                    <input type="text" class="form-control" name="name" value="{{old('name')}}"/>
                </div>
                <div class="form-group">
                    <label for="price">價格:</label>
                    <input type="text" class="form-control" name="price" value="{{old('price')}}"/>
                </div>
                <div class="form-group">
                    <label for="specification">規格:</label>
                    <input type="text" class="form-control" name="specification" value="{{old('specification')}}"/>
                </div>
                <div class="form-group">
                    <label for="stock">剩餘存貨:</label>
                    <input type="text" class="form-control" name="stock" value="{{old('stock')}}"/>
                </div>
                <div class="form-group">
                    <label for="image">商品圖片 :</label>
                    <input type="file" class="form-control" name="image"/>
                </div>
                <button type="submit" class="btn btn-success">新增</button>
                <a href="/seller/commodity/{{ $spu_id }}" class="btn btn-light">取消</a>
            </form>
        </div>
    </div>
</div>
@endsection
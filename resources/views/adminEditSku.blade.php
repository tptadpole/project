@extends('admin')

@section('content')
<div class="container">
    <div class="card uper">
        <div class="card-header">
            編輯商品名稱,商品規格,商品價格,商品存貨與商品圖片
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
            <form method="post" action="/admin/sku/{{$sku['id']}}/update" enctype="multipart/form-data" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group">
                    @csrf
                    <label for="name">商品名稱:</label>
                    <input type="text" class="form-control" name="name" value="{{$sku['name']}}"/>
                </div>
                <div class="form-group">
                    <label for="specification">商品規格 :</label>
                    <input type="text" class="form-control" name="specification" value="{{$sku['specification']}}"/>
                </div>
                <div class="form-group">
                    <label for="price">商品價格 :</label>
                    <input type="text" class="form-control" name="price" value="{{$sku['price']}}"/>
                </div>
                <div class="form-group">
                    <label for="stock">商品存貨 :</label>
                    <input type="text" class="form-control" name="stock" value="{{$sku['stock']}}"/>
                </div>
                <div class="form-group">
                    <label for="image">商品圖片 :</label>
                    <input type="file" class="form-control" name="image"/>
                </div>
                <button type="submit" class="btn btn-success">確定編輯</button>
            </form>
        </div>
    </div>
</div>
@endsection
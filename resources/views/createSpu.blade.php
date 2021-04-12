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
        新增商品資料
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
            <form method="post" action="{{ url('/seller/store') }}" enctype="multipart/form-data">
                <div class="form-group">
                    @csrf
                    <label for="name">商品標題:</label>
                    <input type="text" class="form-control" name="name"/>
                </div>
                <div class="form-group">
                    <label for="description">商品描述(敘述多一些會讓你的商品有更好的表達) :</label>
                    <textarea rows="5" columns="5" class="form-control" name="description"></textarea>
                </div>
                <div class="form-group">
                    <label for="image">商品圖片 :</label>
                    <input type="file" class="form-control" name="image"/>
                </div>
                <button type="submit" class="btn btn-success">新增</button>
            </form>
        </div>
    </div>
</div>
@endsection
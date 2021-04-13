@extends('admin')

@section('content')
<div class="container">
    <div class="card uper">
        <div class="card-header">
            編輯商品標題,商品敘述與商品圖片
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
            <form method="post" action="/admin/spu/{{$spu['id']}}/update" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group">
                    @csrf
                    <label for="name">商品標題:</label>
                    <input type="text" class="form-control" name="name" value="{{$spu['name']}}"/>
                </div>
                <div class="form-group">
                    <label for="description">商品敘述 :</label>
                    <input type="text" class="form-control" name="description" value="{{$spu['description']}}"/>
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
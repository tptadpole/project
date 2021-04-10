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
            <form method="post" action="/seller/{{$data['id']}}/update">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group">
                    @csrf
                    <label for="name">商品種類 :</label>
                    <input type="text" class="form-control" name="name" value="{{$data['name']}}"/>
                </div>
                <div class="form-group">
                    <label for="description">商品描述(敘述多一些會讓你的商品有更好的表達) :</label>
                    <textarea rows="5" columns="5" class="form-control" name="description" value="{{$data['description']}}"></textarea>
                </div>
                <button type="submit" class="btn btn-success">確定編輯</button>
            </form>
        </div>
    </div>
</div>
@endsection
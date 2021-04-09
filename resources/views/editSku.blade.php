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
        編輯商品售價與容量與存貨
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
            <?php
                //dd($data);
            ?>
            <form method="post" action="/seller/commodity/{{$data['id']}}/update">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group">
                    @csrf
                    <label for="price">商品價格:</label>
                    <input type="text" class="form-control" name="price" value="{{$data['price']}}"/>
                </div>
                <div class="form-group">
                    <label for="capacity">商品容量 :</label>
                    <input type="text" class="form-control" name="capacity" value="{{$data['capacity']}}"/>
                </div>
                <div class="form-group">
                    <label for="stock">商品存貨 :</label>
                    <input type="text" class="form-control" name="stock" value="{{$data['stock']}}"/>
                </div>
                <button type="submit" class="btn btn-success">確定編輯</button>
            </form>
        </div>
    </div>
</div>
@endsection
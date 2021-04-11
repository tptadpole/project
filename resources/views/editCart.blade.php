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
            <form method="post" action="/cart/{{$cart['id']}}/update">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group row">
                    @csrf
                    <div class="col-sm-2 col-form-label">商品名稱</div>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" value="{{$sku['name']}}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label">價格</div>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" value="{{$sku['price']}}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label">容量</div>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" value="{{$sku['capacity']}}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label">剩餘存貨</div>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" value="{{$sku['stock']}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="amount">數量 :</label>
                    <input type="number" class="form-control form-control-lg text-center" name="amount" value="1" min="1" max="{{$sku['stock']}}">
                </div>
                <button type="submit" class="btn btn-success">確定編輯</button>
            </form>
        </div>
    </div>
</div>
@endsection
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
        請填寫您的付費資訊
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
            <form method="post" action="/order/store" autocomplete="off">
                <div class="form-group">
                    @csrf
                    <label for="name">簽收者姓名:</label>
                    <input type="text" class="form-control" name="name" value="{{old('name')}}"/>
                </div>
                <div class="form-group">
                    <label for="address">地址:</label>
                    <input type="text" class="form-control" name="address" value="{{old('address')}}"/>
                </div>
                <div class="form-group">
                    <label for="phone">手機號碼:</label>
                    <input type="text" class="form-control" name="phone" value="{{old('phone')}}"/>
                </div>
                <div class="form-group">
                    <label for="total_amount">總金額</label>
                    <input type="text" readonly class="form-control-plaintext" name="total_amount" value="{{$totalPrice}}">
                </div>
                <form class="form-inline">
                    <label class="my-1 mr-2" for="payment">Payment</label>
                    <select class="custom-select my-1 mr-sm-2" name="payment">
                      <option selected>請選擇支付方式...</option>
                      <option value="credit-card">信用卡支付</option>
                      <option value="cash">貨到付款</option>
                    </select>
                    <button type="submit" class="btn btn-success">確定付款</button>
                </form>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<style>
    .uper {
      margin-top: 40px;
    }
</style>
<section class="pt-5 pb-5">
    <div class="container">
        <div class="row w-100">
            <div class="col-lg-12 col-md-12 col-12">
                <h3 class="display-5 mb-2 text-center">104電商購物車</h3>
                <p class="mb-5 text-center">
                    <i class="text-info font-weight-bold">{{count($cart)}}</i> 件商品在購物車中</p>
                <table id="shoppingCart" class="table table-condensed table-responsive">
                    <thead>
                        <tr>
                            <th style="width:30%">商品名稱</th>
                            <th style="width:12%">單價</th>
                            <th style="width:10%">數量</th>
                            <th style="width:16%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $cart as $carts )
                        <tr>                               
                            <td data-th="Product">
                                <div class="row">
                                    <div class="col-md-3 text-left">
                                        <img src="https://via.placeholder.com/250x250/5fa9f8/ffffff" alt="" class="img-fluid d-none d-md-block rounded mb-2 shadow ">
                                    </div>
                                    <div class="col-md-9 text-left mt-sm-2">
                                        <h4>{{$carts['name']}}</h4>
                                        <p class="font-weight-light">{{$carts['capacity']}}ml</p>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Price">{{$carts['price']}}元</td>
                            <td data-th="Quantity">
                                {{$carts['pivot']['amount']}}
                            </td>
                            <td class="actions" data-th="">
                                <div class="row">
                                <a href="/cart/{{$carts['pivot']['id']}}/edit">
                                    <button class="btn btn-sm btn-success border-secondary">
                                    <span data-feather="edit"></span>修改數量
                                    </button>
                                </a>
                                <form action="/cart/{{$carts['pivot']['id']}}/destroy" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-danger" value="刪除">
                                    </div>
                                </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="float-right text-right">
                    <h4>總金額:</h4>
                    <h1>{{$total}}元</h1>
                </div>
            </div>
        </div>
        <div class="row mt-4 d-flex align-items-center">
            <div class="col-sm-6 order-md-2 text-right">
                <a href="catalog.html" class="btn btn-primary mb-4 btn-lg pl-5 pr-5">結帳</a>
            </div>
            <div class="col-sm-6 mb-3 mb-m-1 order-md-1 text-md-left">
                <a href="/customer">
                    <i class="fas fa-arrow-left mr-2"></i>繼續購物</a>
            </div>
        </div>
    </div>
    </section>
@endsection
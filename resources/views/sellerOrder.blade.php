@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">訂單id</th>
            <th scope="col">商品id</th>
            <th scope="col">數量</th>
            <th scope="col">單價</th>
            <th scope="col">狀態</th>
            <th scope="col">下訂時間</th>
            <th scope="col">操作</th>
          </tr>
        </thead>
        <tbody>
        @foreach( $orders as $order ) 
          <tr>
            <td>{{$order['id']}}</td>
            <td>{{$order['order_id']}}</td>
            <td>{{$order['sku_id']}}</td>
            <td>{{$order['amount']}}</td>
            <td>{{$order['price']}}</td>
            <td>{{$order['status']}}</td>
            <td>{{$order['updated_at']}}</td>
            @if( $role == 'seller' )
                <td>
                    <form action="/orderItem/{{$order['id']}}/update" method="post">    
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <form class="form-inline">
                            @csrf
                            <label class="my-1 mr-2" for="status">操作</label>
                            <select class="custom-select my-1 mr-sm-2" name="status">
                              <option selected>請選擇處理方式...</option>
                              <option value="運送中">運送中</option>
                              <option value="取消">取消</option>
                            </select>
                            <button type="submit" class="btn btn-success">確定</button>
                        </form>
                    </form>
                </td>
            @endif
            @if( $role == 'customer' && $order['status'] == '取貨' )
                <td>
                    <form action="/orderItem/{{$order['id']}}/update" method="post">    
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <form class="form-inline">
                            @csrf
                            <label class="my-1 mr-2" for="status">操作</label>
                            <select class="custom-select my-1 mr-sm-2" name="status">
                              <option selected>請選擇處理方式...</option>
                              <option value="完成">取貨</option>
                            </select>
                            <button type="submit" class="btn btn-success">確定</button>
                        </form>
                    </form>
                </td>
            @endif
          </tr>
        @endforeach
        </tbody>
    </table>

    <div class="card text-center">
        <div class="card-body">
            <a href="/order" class="btn btn-success">點擊我回上一頁</a>
        </div>
    </div>
</div>
@endsection
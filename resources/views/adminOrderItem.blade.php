@extends('admin')

@section('content')
<div class="container">
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">賣家id</th>
            <th scope="col">訂單id</th>
            <th scope="col">商品id</th>
            <th scope="col">數量</th>
            <th scope="col">價格</th>
            <th scope="col">狀態</th>
            <th scope="col">最後修改時間</th>
            <th scope="col">刪除時間</th>
            <th scope="col">刪除</th>
          </tr>
        </thead>
        <tbody>
        @foreach( $orderItems as $orderItem ) 
          <tr>
            <td>{{$orderItem['id']}}</td>
            <td>{{$orderItem['users_id']}}</td>
            <td>{{$orderItem['order_id']}}</td>
            <td>{{$orderItem['sku_id']}}</td>
            <td>{{$orderItem['amount']}}</td>
            <td>{{$orderItem['price']}}</td>
            <td>{{$orderItem['status']}}</td>
            <td>{{$orderItem['updated_at']}}</td>
            <td>
              @if ( $orderItem['deleted_at'] )
                {{$orderItem['deleted_at']}}
              @endif
            </td>
            <td>
              <form action="/admin/orderItem/{{$orderItem['id']}}/destroy" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <div class="form-group">
                    <input type="submit" class="btn btn-danger" value="刪除">
                </div>
              </form>
            </td>
          </tr>
        @endforeach
        </tbody>
    </table>
    {!! $orderItems->links() !!}
</div>
@endsection
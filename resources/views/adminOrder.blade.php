@extends('admin')

@section('content')
<div class="container">
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">訂單id</th>
            <th scope="col">總金額</th>
            <th scope="col">地址</th>
            <th scope="col">手機號碼</th>
            <th scope="col">付費方式</th>
            <th scope="col">下訂時間</th>
            <th scope="col">刪除時間</th>
            <th scope="col">操作</th>
          </tr>
        </thead>
        <tbody>
        @foreach( $orders as $order ) 
          <tr>
            <td>{{$order['id']}}</td>
            <td>{{$order['total_amount']}}</td>
            <td>{{$order['address']}}</td>
            <td>{{$order['phone']}}</td>
            <td>{{$order['payment']}}</td>
            <td>{{$order['created_at']}}</td>
            <td>
              @if ($order['deleted_at'])
                {{$order['deleted_at']}}
              @endif
            </td>
            <td>
                <div class="form-group">
                    <a href="/admin/orderItem/{{$order['id']}}/display" class="btn btn-primary">查看更多</a>
                </div>
            </td>
            <td>
                <form action="/admin/order/{{$order['id']}}/destroy" method="POST">
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
    <div class="card text-center">
        <div class="card-body">
            <p class="card-text">感謝你使用104電商來購買物品,用過的都說讚</p>
            <a href="/" class="btn btn-success">點擊我回首頁</a>
        </div>
    </div>
</div>
@endsection
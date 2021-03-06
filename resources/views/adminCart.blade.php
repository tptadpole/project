@extends('admin')

@section('content')
<div class="container">
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">買家id</th>
            <th scope="col">商品名稱</th>
            <th scope="col">商品圖片</th>
            <th scope="col">商品規格</th>
            <th scope="col">商品價格</th>
            <th scope="col">購買數量</th>
            <th scope="col">最後修改時間</th>
            <th scope="col">刪除</th>
          </tr>
        </thead>
        <tbody>
        @foreach( $carts as $cart ) 
          <tr>
            <td>{{$cart['id']}}</td>
            <td>{{$cart['users_id']}}</td>
            @if ( $cart['sku'] )
              <td>{{$cart['sku']['name']}}</td>
              <td>
                @if($cart['sku']['image'])
                  <img src="https://104-aws-training-cicd-bucket.s3-ap-northeast-1.amazonaws.com/garyke/garyke-demo/image/{{$cart['sku']['image']}} "width="100px;" height="100px;" />
                @endif
              </td>
              <td>{{$cart['sku']['specification']}}</td>
              <td>{{$cart['sku']['price']}}</td>
            @endif
            <td>{{$cart['amount']}}</td>
            <td>{{$cart['updated_at']}}</td>
            <td>
              <form action="/admin/cart/{{$cart['id']}}/destroy" method="POST">
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
    {!! $link->links() !!}
</div>
@endsection
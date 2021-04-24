@extends('admin')

@section('content')
<div class="container">
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">商品Id</th>
            <th scope="col">商品標題id</th>
            <th scope="col">商品名稱</th>
            <th scope="col">商品圖片</th>
            <th scope="col">規格</th>
            <th scope="col">價格</th>
            <th scope="col">存貨</th>
            <th scope="col">最後修改時間</th>
            <th scope="col">修改</th>
            <th scope="col">刪除</th>
          </tr>
        </thead>
        <tbody>
        @foreach( $skus as $sku ) 
          <tr>
            <td>{{$sku['id']}}</td>
            <td>{{$sku['spu_id']}}</td>
            <td>{{$sku['name']}}</td>
            <td>
                <img src="{{Storage::disk('s3')->url('garyke/garyke-demo/image/' . $sku['image'])}} "width="100px;" height="100px;" /> 
            </td>
            <td>{{$sku['specification']}}</td>
            <td>{{$sku['price']}}</td>
            <td>{{$sku['stock']}}</td>
            <td>{{$sku['updated_at']}}</td>
            <td>
              <a href="/admin/sku/{{$sku['id']}}/edit">
                  <button type="button" class="btn btn-primary">修改</button>
              </a>
            </td>
            <td>
              <form action="/admin/sku/{{$sku['id']}}/destroy" method="POST">
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
    {!! $skus->links() !!}
</div>
@endsection
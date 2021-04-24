@extends('admin')

@section('content')
<div class="container">
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">賣家id</th>
            <th scope="col">商品標題</th>
            <th scope="col">圖片</th>
            <th scope="col">敘述</th>
            <th scope="col">最後修改時間</th>
          </tr>
        </thead>
        <tbody>
        @foreach( $spus as $spu ) 
          <tr>
            <td>{{$spu['id']}}</td>
            <td>{{$spu['users_id']}}</td>
            <td>{{$spu['name']}}</td>
            <td>
              @if($spu['image'])
                <img src="https://104-aws-training-cicd-bucket.s3-ap-northeast-1.amazonaws.com/garyke/garyke-demo/image/{{$spu['image']}} "width="250px;" height="250px;" />
              @endif
            </td>
            <td>{{$spu['description']}}</td>
            <td>{{$spu['updated_at']}}</td>
            <td>
              <a href="/admin/spu/{{$spu['id']}}/edit">
                  <button type="button" class="btn btn-primary">修改</button>
              </a>
            </td>
            <td>
              <form action="/admin/spu/{{$spu['id']}}/destroy" method="POST">
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
    {!! $spus->links() !!}
</div>
@endsection
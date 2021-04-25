@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">商品物品id</th>
            <th scope="col">商品物品名稱</th>
            <th scope="col">商品物品圖片</th>
            <th scope="col">評論</th>
            <th scope="col">操作</th>
          </tr>
        </thead>
        <tbody>
        @foreach( $comments as $comment ) 
          <tr>
            <td>{{$comment['id']}}</td>
            <td>{{$comment['name']}}</td>          
            <td>
                @if($comment['image'])
                    <img src="https://104-aws-training-cicd-bucket.s3-ap-northeast-1.amazonaws.com/garyke/garyke-demo/image/{{$comment['image']}} "width="100px;" height="100px;" />
                @endif
            </td>
            <td>{{$comment['pivot']['comment']}}</td>
            <td>
                <a href="/comment/{{$comment['pivot']['id']}}/edit" class="btn btn-primary">修改</a>
                <form action="/comment/{{$comment['pivot']['id']}}/destroy" method="POST">
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
</div>
@endsection
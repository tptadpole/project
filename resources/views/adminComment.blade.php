@extends('admin')

@section('content')
<div class="container">
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">評論id</th>
            <th scope="col">評論者id</th>
            <th scope="col">商品物品id</th>
            <th scope="col">評論</th>
            <th scope="col">操作</th>
          </tr>
        </thead>
        <tbody>
        @foreach( $comments as $comment ) 
          <tr>
            <td>{{$comment['id']}}</td>
            <td>{{$comment['users_id']}}</td>
            <td>{{$comment['sku_id']}}</td>
            <td>{{$comment['comment']}}</td>
            <td>
                <form action="/admin/comment/{{$comment['id']}}/destroy" method="POST">
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
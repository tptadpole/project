@extends('admin')

@section('content')
<div class="container">
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">用戶名</th>
            <th scope="col">Role</th>
            <th scope="col">信箱</th>
            <th scope="col">修改</th>
            <th scope="col">刪除</th>
          </tr>
        </thead>
        <tbody>
        @foreach( $users as $user ) 
          <tr>
            <td>{{$user['id']}}</td>
            <td>{{$user['name']}}</td>
            <td>{{$user['role']}}</td>
            <td>{{$user['email']}}</td>
            <td>
              <a href="/admin/users/{{$user['id']}}/edit">
                  <button type="button" class="btn btn-primary">修改</button>
              </a>
            </td>
            <td>
              <form action="/admin/users/{{$user['id']}}/destroy" method="POST">
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
            <h5 class="card-title">要直接新增會員嗎?</h5>
            <p class="card-text">Admin請小心使用</p>
            <a href="/admin/users/create" class="btn btn-success">新增會員</a>
        </div>
    </div>
    {!! $users->links() !!}
</div>
@endsection
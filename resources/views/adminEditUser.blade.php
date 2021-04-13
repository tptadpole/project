@extends('admin')

@section('content')
<div class="container">
    <div class="card uper">
        <div class="card-header">
            編輯會員名稱,角色,信箱
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div><br/>
            @endif
            <form method="post" action="/admin/users/{{$user['id']}}/update">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group">
                    @csrf
                    <label for="name">會員名稱:</label>
                    <input type="text" class="form-control" name="name" value="{{$user['name']}}"/>
                </div>
                <div class="form-group">
                    <label for="password">會員密碼 :</label>
                    <input type="text" class="form-control" name="password"/>
                </div>
                <div class="form-group">
                    <label for="role">會員角色(user,manager,admin) :</label>
                    <input type="text" class="form-control" name="role" value="{{$user['role']}}"/>
                </div>
                <div class="form-group">
                    <label for="email">會員信箱(請記得更換) :</label>
                    <input type="text" class="form-control" name="email" value="{{$user['email']}}"/>
                </div>
                <button type="submit" class="btn btn-success">確定編輯</button>
            </form>
        </div>
    </div>
</div>
@endsection
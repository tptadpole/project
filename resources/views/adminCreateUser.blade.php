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
            <form method="post" action="/admin/users/store" autocomplete="off">
                <div class="form-group">
                    @csrf
                    <label for="name">會員名稱:</label>
                    <input type="text" class="form-control" name="name"/>
                </div>
                <div class="form-group">
                    <label for="password">會員密碼 :</label>
                    <input type="text" class="form-control" name="password"/>
                </div>
                <div class="form-group">
                    <label for="role">會員角色(user,manager,admin) :</label>
                    <input type="text" class="form-control" name="role"/>
                </div>
                <div class="form-group">
                    <label for="email">會員信箱 :</label>
                    <input type="text" class="form-control" name="email"/>
                </div>
                <button type="submit" class="btn btn-success">新增</button>
            </form>
        </div>
    </div>
</div>
@endsection
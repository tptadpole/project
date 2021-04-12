@extends('admin')

@section('content')
<div class="container">
    <div class="card uper">
        <div class="card-header">
            編輯商品售價與容量與存貨
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
            <form method="post" action="/admin/user/{{$user['id']}}/update">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group row">
                    @csrf
                    <div class="col-sm-2 col-form-label">用戶名稱</div>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" value="{{$user['name']}}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label">Role</div>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" value="{{$user['role']}}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label">信箱</div>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" value="{{$user['email']}}">
                    </div>
                </div>
                <button type="submit" class="btn btn-success">確定編輯</button>
            </form>
        </div>
    </div>
</div>
@endsection
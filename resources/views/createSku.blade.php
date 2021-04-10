@extends('layouts.app')

@section('content')
<style>
    .uper {
      margin-top: 40px;
    }
</style>
<div class="container">
    <div class="card uper">
        <div class="card-header">
        新增商品細項資料
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
            <form method="post" action="/seller/commodity/{{ $spu_id }}/store">
                <div class="form-group">
                    @csrf
                    <label for="name">商品名稱:</label>
                    <input type="text" class="form-control" name="name"/>
                </div>
                <div class="form-group">
                    <label for="price">價格:</label>
                    <input type="text" class="form-control" name="price"/>
                </div>
                <div class="form-group">
                    <label for="capacity">飲料容量:</label>
                    <input type="text" class="form-control" name="capacity"/>
                </div>
                <div class="form-group">
                    <label for="stock">剩餘存貨:</label>
                    <input type="text" class="form-control" name="stock"/>
                </div>
                
                <button type="submit" class="btn btn-success">新增</button>
            </form>
        </div>
    </div>
</div>
@endsection
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
            編輯評論
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
            <form method="post" action="/comment/{{$comment->id}}/update">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group row">
                    @csrf
                    <div class="col-auto">
                        <label for="comment">評論 :</label>
                        <input type="text" value="{{$comment->comment}}" name="comment">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-success">確定編輯</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
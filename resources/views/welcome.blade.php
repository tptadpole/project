@extends('layouts.app')
 
@section('content')
    <div class="container">
        首頁
        @can('admin')
            <p>Hello ~ 系統管理者</p>
        @elsecan('manager')
            <p>一般管理者</p>
        @elsecan('user')
            <p>一般使用者</p>
        @else
            <p>遊客</p>
        @endcan
    </div>
@endsection
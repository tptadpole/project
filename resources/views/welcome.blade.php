@extends('layouts.app')

@section('content')

@if (Route::has('login'))

    @auth
        @can('admin')
            <!-- 系統管理者 -->
            <p>您好,系統管理者：{{ Auth::user()->name }}</p>
        @elsecan('manager')
            <!-- 一般管理者 -->
            <p>您好,一般管理者：{{ Auth::user()->name }}</p>
        @else
            <!-- 一般使用者 -->
            <p>您好,一般使用者：{{ Auth::user()->name }}</p>
        @endcan
    @else
        <p>您好,遊客</p>
    @endauth

@endif
@endsection
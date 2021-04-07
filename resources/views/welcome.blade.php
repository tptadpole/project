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
    <div class="container">
        <div class="card">
            <ul class="list-group">
                @foreach( $homepageProducts as $homepageProduct )
                    <li class="list-group-item">
                        <ul type="disc"><li>{{$homepageProduct['name']}}</li> </ul>     
                    </li>
                    <li class="list-group-item">
                        <ul type="disc"><li>{{$homepageProduct['description']}}</li> </ul>     
                    </li>
                    <li class="list-group-item">
                        <ul type="disc"><li>{{$homepageProduct['vote']}}</li> </ul>     
                    </li>
                    <li class="list-group-item">
                        <ul type="disc"><li>{{$homepageProduct['comment']}}</li> </ul>     
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
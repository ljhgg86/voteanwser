@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')

<div class="row">

    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
        <div class="card">
            <div align="center">
                <img class=" card-img-top thumbnail img-responsive" src="{{ $user->avatar }}" width="300px" height="300px" style="padding:15px">
            </div>
            <div class="card-body">
                <div class="media-body">
                    <hr>
                    <h4><strong>个人简介</strong></h4>
                    <p>{{ $user->introduction }}</p>
                    <hr>
                    <h4><strong>注册于</strong></h4>
                    <p>{{ $user->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <span>
                    <h1 class="card-title float-left" style="font-size:30px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
                </span>
            </div>
        </div>
        <hr>

        {{-- 用户发布的内容 --}}
        <div class="card">
            <div class="card-body">
                暂无数据 ~_~
            </div>
        </div>

    </div>
</div>
@stop
@extends('layouts.app')

@section('title', '首页')

@section('content')
    <div class="jumbotron">
    <h1>Hello Vote</h1>
    <p class="lead">
      你现在所看到的是 <a href="#">汕头橄榄台</a> 的投票管理系统。
    </p>
    <p>
      一切，将从这里开始。
    </p>
    <p>
      <a class="btn btn-lg btn-success" href="{{ route('login') }}" role="button">现在登录</a>
    </p>
  </div>
@stop

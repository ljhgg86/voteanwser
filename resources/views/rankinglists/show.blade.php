@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Rankinglist / Show #{{ $rankinglist->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('rankinglists.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('rankinglists.edit', $rankinglist->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>
User_id</label>
<p>
	{{ $rankinglist->
user_id }}
</p> <label>Poll_id</label>
<p>
	{{ $rankinglist->poll_id }}
</p> <label>Correct_num</label>
<p>
	{{ $rankinglist->correct_num }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection

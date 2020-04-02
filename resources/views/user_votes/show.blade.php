@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>UserVote / Show #{{ $user_vote->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('user_votes.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('user_votes.edit', $user_vote->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>
Vote_id</label>
<p>
	{{ $user_vote->
vote_id }}
</p> <label>Option_id</label>
<p>
	{{ $user_vote->option_id }}
</p> <label>User_id</label>
<p>
	{{ $user_vote->user_id }}
</p> <label>Correct</label>
<p>
	{{ $user_vote->correct }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection

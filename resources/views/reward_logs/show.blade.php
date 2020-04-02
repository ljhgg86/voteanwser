@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>RewardLog / Show #{{ $reward_log->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('reward_logs.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('reward_logs.edit', $reward_log->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>
Reward_id</label>
<p>
	{{ $reward_log->
reward_id }}
</p> <label>User_id</label>
<p>
	{{ $reward_log->user_id }}
</p> <label>Reward_type</label>
<p>
	{{ $reward_log->reward_type }}
</p> <label>Reward_count</label>
<p>
	{{ $reward_log->reward_count }}
</p> <label>Remark</label>
<p>
	{{ $reward_log->remark }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection

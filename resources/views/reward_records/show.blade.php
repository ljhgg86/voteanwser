@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>RewardRecord / Show #{{ $reward_record->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('reward_records.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('reward_records.edit', $reward_record->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>
Reward_id</label>
<p>
	{{ $reward_record->
reward_id }}
</p> <label>User_id</label>
<p>
	{{ $reward_record->user_id }}
</p> <label>Reward_type</label>
<p>
	{{ $reward_record->reward_type }}
</p> <label>Redeemflag</label>
<p>
	{{ $reward_record->redeemflag }}
</p> <label>Redeem_at</label>
<p>
	{{ $reward_record->redeem_at }}
</p> <label>Vote_id</label>
<p>
	{{ $reward_record->vote_id }}
</p> <label>Remark</label>
<p>
	{{ $reward_record->remark }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection

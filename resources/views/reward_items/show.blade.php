@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>RewardItem / Show #{{ $reward_item->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('reward_items.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('reward_items.edit', $reward_item->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Reward_id</label>
<p>
	{{ $reward_item->reward_id }}
</p> <label>Poll_id</label>
<p>
	{{ $reward_item->poll_id }}
</p> <label>Vote_id</label>
<p>
	{{ $reward_item->vote_id }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> RewardItem /
                    @if($reward_item->id)
                        Edit #{{$reward_item->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($reward_item->id)
                    <form action="{{ route('reward_items.update', $reward_item->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('reward_items.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                    <label for="reward_id-field">Reward_id</label>
                    <input class="form-control" type="text" name="reward_id" id="reward_id-field" value="{{ old('reward_id', $reward_item->reward_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="poll_id-field">Poll_id</label>
                    <input class="form-control" type="text" name="poll_id" id="poll_id-field" value="{{ old('poll_id', $reward_item->poll_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="vote_id-field">Vote_id</label>
                    <input class="form-control" type="text" name="vote_id" id="vote_id-field" value="{{ old('vote_id', $reward_item->vote_id ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('reward_items.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
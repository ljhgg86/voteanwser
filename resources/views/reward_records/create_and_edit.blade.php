@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> RewardRecord /
                    @if($reward_record->id)
                        Edit #{{$reward_record->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($reward_record->id)
                    <form action="{{ route('reward_records.update', $reward_record->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('reward_records.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                    <label for="
reward_id-field">
Reward_id</label>
                    <input class="form-control" type="text" name="
reward_id" id="
reward_id-field" value="{{ old('
reward_id', $reward_record->
reward_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="user_id-field">User_id</label>
                    <input class="form-control" type="text" name="user_id" id="user_id-field" value="{{ old('user_id', $reward_record->user_id ) }}" />
                </div> 
                <div class="form-group">
                	<label for="reward_type-field">Reward_type</label>
                	<input class="form-control" type="text" name="reward_type" id="reward_type-field" value="{{ old('reward_type', $reward_record->reward_type ) }}" />
                </div> 
                <div class="form-group">
                    <label for="redeemflag-field">Redeemflag</label>
                    <input class="form-control" type="text" name="redeemflag" id="redeemflag-field" value="{{ old('redeemflag', $reward_record->redeemflag ) }}" />
                </div> 
                <div class="form-group">
                    <label for="redeem_at-field">Redeem_at</label>
                    <input class="form-control" type="text" name="redeem_at" id="redeem_at-field" value="{{ old('redeem_at', $reward_record->redeem_at ) }}" />
                </div> 
                <div class="form-group">
                    <label for="vote_id-field">Vote_id</label>
                    <input class="form-control" type="text" name="vote_id" id="vote_id-field" value="{{ old('vote_id', $reward_record->vote_id ) }}" />
                </div> 
                <div class="form-group">
                	<label for="remark-field">Remark</label>
                	<input class="form-control" type="text" name="remark" id="remark-field" value="{{ old('remark', $reward_record->remark ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('reward_records.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
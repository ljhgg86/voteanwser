@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> RewardLog /
                    @if($reward_log->id)
                        Edit #{{$reward_log->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($reward_log->id)
                    <form action="{{ route('reward_logs.update', $reward_log->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('reward_logs.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                    <label for="
reward_id-field">
Reward_id</label>
                    <input class="form-control" type="text" name="
reward_id" id="
reward_id-field" value="{{ old('
reward_id', $reward_log->
reward_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="user_id-field">User_id</label>
                    <input class="form-control" type="text" name="user_id" id="user_id-field" value="{{ old('user_id', $reward_log->user_id ) }}" />
                </div> 
                <div class="form-group">
                	<label for="reward_type-field">Reward_type</label>
                	<input class="form-control" type="text" name="reward_type" id="reward_type-field" value="{{ old('reward_type', $reward_log->reward_type ) }}" />
                </div> 
                <div class="form-group">
                    <label for="reward_count-field">Reward_count</label>
                    <input class="form-control" type="text" name="reward_count" id="reward_count-field" value="{{ old('reward_count', $reward_log->reward_count ) }}" />
                </div> 
                <div class="form-group">
                	<label for="remark-field">Remark</label>
                	<input class="form-control" type="text" name="remark" id="remark-field" value="{{ old('remark', $reward_log->remark ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('reward_logs.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
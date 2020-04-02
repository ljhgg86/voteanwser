@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> UserVote /
                    @if($user_vote->id)
                        Edit #{{$user_vote->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($user_vote->id)
                    <form action="{{ route('user_votes.update', $user_vote->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('user_votes.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                    <label for="
vote_id-field">
Vote_id</label>
                    <input class="form-control" type="text" name="
vote_id" id="
vote_id-field" value="{{ old('
vote_id', $user_vote->
vote_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="option_id-field">Option_id</label>
                    <input class="form-control" type="text" name="option_id" id="option_id-field" value="{{ old('option_id', $user_vote->option_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="user_id-field">User_id</label>
                    <input class="form-control" type="text" name="user_id" id="user_id-field" value="{{ old('user_id', $user_vote->user_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="correct-field">Correct</label>
                    <input class="form-control" type="text" name="correct" id="correct-field" value="{{ old('correct', $user_vote->correct ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('user_votes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> Vote /
                    @if($vote->id)
                        Edit #{{$vote->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($vote->id)
                    <form action="{{ route('votes.update', $vote->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('votes.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                    <label for="poll_id-field">Poll_id</label>
                    <input class="form-control" type="text" name="poll_id" id="poll_id-field" value="{{ old('poll_id', $vote->poll_id ) }}" />
                </div> 
                <div class="form-group">
                	<label for="title-field">Title</label>
                	<input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $vote->title ) }}" />
                </div> 
                <div class="form-group">
                	<label for="thumbnail-field">Thumbnail</label>
                	<input class="form-control" type="text" name="thumbnail" id="thumbnail-field" value="{{ old('thumbnail', $vote->thumbnail ) }}" />
                </div> 
                <div class="form-group">
                    <label for="start_at-field">Start_at</label>
                    <input class="form-control" type="text" name="start_at" id="start_at-field" value="{{ old('start_at', $vote->start_at ) }}" />
                </div> 
                <div class="form-group">
                    <label for="end_at-field">End_at</label>
                    <input class="form-control" type="text" name="end_at" id="end_at-field" value="{{ old('end_at', $vote->end_at ) }}" />
                </div> 
                <div class="form-group">
                    <label for="view_end_at-field">View_end_at</label>
                    <input class="form-control" type="text" name="view_end_at" id="view_end_at-field" value="{{ old('view_end_at', $vote->view_end_at ) }}" />
                </div> 
                <div class="form-group">
                    <label for="option_count-field">Option_count</label>
                    <input class="form-control" type="text" name="option_count" id="option_count-field" value="{{ old('option_count', $vote->option_count ) }}" />
                </div> 
                <div class="form-group">
                    <label for="option_type-field">Option_type</label>
                    <input class="form-control" type="text" name="option_type" id="option_type-field" value="{{ old('option_type', $vote->option_type ) }}" />
                </div> 
                <div class="form-group">
                    <label for="vote_type-field">Vote_type</label>
                    <input class="form-control" type="text" name="vote_type" id="vote_type-field" value="{{ old('vote_type', $vote->vote_type ) }}" />
                </div> 
                <div class="form-group">
                    <label for="vote_count-field">Vote_count</label>
                    <input class="form-control" type="text" name="vote_count" id="vote_count-field" value="{{ old('vote_count', $vote->vote_count ) }}" />
                </div> 
                <div class="form-group">
                    <label for="show_votecount-field">Show_votecount</label>
                    <input class="form-control" type="text" name="show_votecount" id="show_votecount-field" value="{{ old('show_votecount', $vote->show_votecount ) }}" />
                </div> 
                <div class="form-group">
                	<label for="description-field">Description</label>
                	<textarea name="description" id="description-field" class="form-control" rows="3">{{ old('description', $vote->description ) }}</textarea>
                </div> 
                <div class="form-group">
                    <label for="delflag-field">Delflag</label>
                    <input class="form-control" type="text" name="delflag" id="delflag-field" value="{{ old('delflag', $vote->delflag ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('votes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
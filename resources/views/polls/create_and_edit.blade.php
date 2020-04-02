@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> Poll /
                    @if($poll->id)
                        Edit #{{$poll->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($poll->id)
                    <form action="{{ route('polls.update', $poll->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('polls.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                	<label for="title-field">Title</label>
                	<input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $poll->title ) }}" />
                </div> 
                <div class="form-group">
                	<label for="thumbnail-field">Thumbnail</label>
                	<input class="form-control" type="text" name="thumbnail" id="thumbnail-field" value="{{ old('thumbnail', $poll->thumbnail ) }}" />
                </div> 
                <div class="form-group">
                	<label for="description-field">Description</label>
                	<textarea name="description" id="description-field" class="form-control" rows="3">{{ old('description', $poll->description ) }}</textarea>
                </div> 
                <div class="form-group">
                	<label for="rules-field">Rules</label>
                	<textarea name="rules" id="rules-field" class="form-control" rows="3">{{ old('rules', $poll->rules ) }}</textarea>
                </div> 
                <div class="form-group">
                    <label for="category_id-field">Category_id</label>
                    <input class="form-control" type="text" name="category_id" id="category_id-field" value="{{ old('category_id', $poll->category_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="vote_count-field">Vote_count</label>
                    <input class="form-control" type="text" name="vote_count" id="vote_count-field" value="{{ old('vote_count', $poll->vote_count ) }}" />
                </div> 
                <div class="form-group">
                    <label for="show_votecount-field">Show_votecount</label>
                    <input class="form-control" type="text" name="show_votecount" id="show_votecount-field" value="{{ old('show_votecount', $poll->show_votecount ) }}" />
                </div> 
                <div class="form-group">
                    <label for="createuser_id-field">Createuser_id</label>
                    <input class="form-control" type="text" name="createuser_id" id="createuser_id-field" value="{{ old('createuser_id', $poll->createuser_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="verifyuser_id-field">Verifyuser_id</label>
                    <input class="form-control" type="text" name="verifyuser_id" id="verifyuser_id-field" value="{{ old('verifyuser_id', $poll->verifyuser_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="verifyflag-field">Verifyflag</label>
                    <input class="form-control" type="text" name="verifyflag" id="verifyflag-field" value="{{ old('verifyflag', $poll->verifyflag ) }}" />
                </div> 
                <div class="form-group">
                    <label for="endflag-field">Endflag</label>
                    <input class="form-control" type="text" name="endflag" id="endflag-field" value="{{ old('endflag', $poll->endflag ) }}" />
                </div> 
                <div class="form-group">
                    <label for="delflag-field">Delflag</label>
                    <input class="form-control" type="text" name="delflag" id="delflag-field" value="{{ old('delflag', $poll->delflag ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('polls.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
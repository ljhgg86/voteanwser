@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> Option /
                    @if($option->id)
                        Edit #{{$option->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($option->id)
                    <form action="{{ route('options.update', $option->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('options.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                    <label for="
vote_id-field">
Vote_id</label>
                    <input class="form-control" type="text" name="
vote_id" id="
vote_id-field" value="{{ old('
vote_id', $option->
vote_id ) }}" />
                </div> 
                <div class="form-group">
                	<label for="option-field">Option</label>
                	<input class="form-control" type="text" name="option" id="option-field" value="{{ old('option', $option->option ) }}" />
                </div> 
                <div class="form-group">
                	<label for="thumbnail-field">Thumbnail</label>
                	<input class="form-control" type="text" name="thumbnail" id="thumbnail-field" value="{{ old('thumbnail', $option->thumbnail ) }}" />
                </div> 
                <div class="form-group">
                    <label for="vote_count-field">Vote_count</label>
                    <input class="form-control" type="text" name="vote_count" id="vote_count-field" value="{{ old('vote_count', $option->vote_count ) }}" />
                </div> 
                <div class="form-group">
                	<label for="description-field">Description</label>
                	<textarea name="description" id="description-field" class="form-control" rows="3">{{ old('description', $option->description ) }}</textarea>
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('options.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
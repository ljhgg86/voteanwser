@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> voteInfo /
                    @if($voteInfo->id)
                        Edit #{{$voteInfo->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($voteInfo->id)
                    <form action="{{ route('voteInfos.update', $voteInfo->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('voteInfos.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">


                <div class="form-group">
                    <label for="
vote_id-field">
Vote_id</label>
                    <input class="form-control" type="text" name="
vote_id" id="
vote_id-field" value="{{ old('
vote_id', $voteInfo->
vote_id ) }}" />
                </div>
                <div class="form-group">
                	<label for="info-field">Info</label>
                	<input class="form-control" type="text" name="info" id="info-field" value="{{ old('info', $voteInfo->info ) }}" />
                </div>
                <div class="form-group">
                	<label for="thumbnail-field">Thumbnail</label>
                	<input class="form-control" type="text" name="thumbnail" id="thumbnail-field" value="{{ old('thumbnail', $voteInfo->thumbnail ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('voteInfos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
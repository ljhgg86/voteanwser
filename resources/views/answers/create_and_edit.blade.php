@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> Answer /
                    @if($answer->id)
                        Edit #{{$answer->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($answer->id)
                    <form action="{{ route('answers.update', $answer->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('answers.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                    <label for="
vote_id-field">
Vote_id</label>
                    <input class="form-control" type="text" name="
vote_id" id="
vote_id-field" value="{{ old('
vote_id', $answer->
vote_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="option_id-field">Option_id</label>
                    <input class="form-control" type="text" name="option_id" id="option_id-field" value="{{ old('option_id', $answer->option_id ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('answers.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
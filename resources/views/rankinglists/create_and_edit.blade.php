@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> Rankinglist /
                    @if($rankinglist->id)
                        Edit #{{$rankinglist->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($rankinglist->id)
                    <form action="{{ route('rankinglists.update', $rankinglist->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('rankinglists.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                    <label for="
user_id-field">
User_id</label>
                    <input class="form-control" type="text" name="
user_id" id="
user_id-field" value="{{ old('
user_id', $rankinglist->
user_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="poll_id-field">Poll_id</label>
                    <input class="form-control" type="text" name="poll_id" id="poll_id-field" value="{{ old('poll_id', $rankinglist->poll_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="correct_num-field">Correct_num</label>
                    <input class="form-control" type="text" name="correct_num" id="correct_num-field" value="{{ old('correct_num', $rankinglist->correct_num ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('rankinglists.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
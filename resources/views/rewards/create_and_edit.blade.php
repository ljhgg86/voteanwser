@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> Reward /
                    @if($reward->id)
                        Edit #{{$reward->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($reward->id)
                    <form action="{{ route('rewards.update', $reward->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('rewards.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                    <label for="
id-field">
Id</label>
                    <input class="form-control" type="text" name="
id" id="
id-field" value="{{ old('
id', $reward->
id ) }}" />
                </div> 
                <div class="form-group">
                	<label for="title-field">Title</label>
                	<input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $reward->title ) }}" />
                </div> 
                <div class="form-group">
                	<label for="description-field">Description</label>
                	<textarea name="description" id="description-field" class="form-control" rows="3">{{ old('description', $reward->description ) }}</textarea>
                </div> 
                <div class="form-group">
                    <label for="condition-field">Condition</label>
                    <input class="form-control" type="text" name="condition" id="condition-field" value="{{ old('condition', $reward->condition ) }}" />
                </div> 
                <div class="form-group">
                    <label for="delflag-field">Delflag</label>
                    <input class="form-control" type="text" name="delflag" id="delflag-field" value="{{ old('delflag', $reward->delflag ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('rewards.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Option / Show #{{ $option->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('options.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('options.edit', $option->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>
Vote_id</label>
<p>
	{{ $option->
vote_id }}
</p> <label>Option</label>
<p>
	{{ $option->option }}
</p> <label>Thumbnail</label>
<p>
	{{ $option->thumbnail }}
</p> <label>Vote_count</label>
<p>
	{{ $option->vote_count }}
</p> <label>Description</label>
<p>
	{{ $option->description }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection

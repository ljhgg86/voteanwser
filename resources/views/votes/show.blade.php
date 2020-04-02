@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Vote / Show #{{ $vote->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('votes.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('votes.edit', $vote->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Poll_id</label>
<p>
	{{ $vote->poll_id }}
</p> <label>Title</label>
<p>
	{{ $vote->title }}
</p> <label>Thumbnail</label>
<p>
	{{ $vote->thumbnail }}
</p> <label>Start_at</label>
<p>
	{{ $vote->start_at }}
</p> <label>End_at</label>
<p>
	{{ $vote->end_at }}
</p> <label>View_end_at</label>
<p>
	{{ $vote->view_end_at }}
</p> <label>Option_count</label>
<p>
	{{ $vote->option_count }}
</p> <label>Option_type</label>
<p>
	{{ $vote->option_type }}
</p> <label>Vote_type</label>
<p>
	{{ $vote->vote_type }}
</p> <label>Vote_count</label>
<p>
	{{ $vote->vote_count }}
</p> <label>Show_votecount</label>
<p>
	{{ $vote->show_votecount }}
</p> <label>Description</label>
<p>
	{{ $vote->description }}
</p> <label>Delflag</label>
<p>
	{{ $vote->delflag }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection

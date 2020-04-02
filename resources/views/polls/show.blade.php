@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Poll / Show #{{ $poll->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('polls.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('polls.edit', $poll->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Title</label>
<p>
	{{ $poll->title }}
</p> <label>Thumbnail</label>
<p>
	{{ $poll->thumbnail }}
</p> <label>Description</label>
<p>
	{{ $poll->description }}
</p> <label>Rules</label>
<p>
	{{ $poll->rules }}
</p> <label>Category_id</label>
<p>
	{{ $poll->category_id }}
</p> <label>Vote_count</label>
<p>
	{{ $poll->vote_count }}
</p> <label>Show_votecount</label>
<p>
	{{ $poll->show_votecount }}
</p> <label>Createuser_id</label>
<p>
	{{ $poll->createuser_id }}
</p> <label>Verifyuser_id</label>
<p>
	{{ $poll->verifyuser_id }}
</p> <label>Verifyflag</label>
<p>
	{{ $poll->verifyflag }}
</p> <label>Endflag</label>
<p>
	{{ $poll->endflag }}
</p> <label>Delflag</label>
<p>
	{{ $poll->delflag }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>voteInfo / Show #{{ $voteInfo->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('voteInfos.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('voteInfos.edit', $voteInfo->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>
Vote_id</label>
<p>
	{{ $voteInfo->
vote_id }}
</p> <label>Info</label>
<p>
	{{ $voteInfo->info }}
</p> <label>Thumbnail</label>
<p>
	{{ $voteInfo->thumbnail }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection

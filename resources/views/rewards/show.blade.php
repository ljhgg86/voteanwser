@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Reward / Show #{{ $reward->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('rewards.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('rewards.edit', $reward->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>
Id</label>
<p>
	{{ $reward->
id }}
</p> <label>Title</label>
<p>
	{{ $reward->title }}
</p> <label>Description</label>
<p>
	{{ $reward->description }}
</p> <label>Condition</label>
<p>
	{{ $reward->condition }}
</p> <label>Delflag</label>
<p>
	{{ $reward->delflag }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection

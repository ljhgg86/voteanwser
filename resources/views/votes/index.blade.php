@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-align-justify"></i> Vote
                    <a class="btn btn-success pull-right" href="{{ route('votes.create') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
                </h1>
            </div>

            <div class="panel-body">
                @if($votes->count())
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Poll_id</th> <th>Title</th> <th>Thumbnail</th> <th>Start_at</th> <th>End_at</th> <th>View_end_at</th> <th>Option_count</th> <th>Option_type</th> <th>Vote_type</th> <th>Vote_count</th> <th>Show_votecount</th> <th>Description</th> <th>Delflag</th>
                                <th class="text-right">OPTIONS</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($votes as $vote)
                                <tr>
                                    <td class="text-center"><strong>{{$vote->id}}</strong></td>

                                    <td>{{$vote->poll_id}}</td> <td>{{$vote->title}}</td> <td>{{$vote->thumbnail}}</td> <td>{{$vote->start_at}}</td> <td>{{$vote->end_at}}</td> <td>{{$vote->view_end_at}}</td> <td>{{$vote->option_count}}</td> <td>{{$vote->option_type}}</td> <td>{{$vote->vote_type}}</td> <td>{{$vote->vote_count}}</td> <td>{{$vote->show_votecount}}</td> <td>{{$vote->description}}</td> <td>{{$vote->delflag}}</td>
                                    
                                    <td class="text-right">
                                        <a class="btn btn-xs btn-primary" href="{{ route('votes.show', $vote->id) }}">
                                            <i class="glyphicon glyphicon-eye-open"></i> 
                                        </a>
                                        
                                        <a class="btn btn-xs btn-warning" href="{{ route('votes.edit', $vote->id) }}">
                                            <i class="glyphicon glyphicon-edit"></i> 
                                        </a>

                                        <form action="{{ route('votes.destroy', $vote->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                            {{csrf_field()}}
                                            <input type="hidden" name="_method" value="DELETE">

                                            <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $votes->render() !!}
                @else
                    <h3 class="text-center alert alert-info">Empty!</h3>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
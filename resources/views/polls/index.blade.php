@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-align-justify"></i> Poll
                    <a class="btn btn-success pull-right" href="{{ route('polls.create') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
                </h1>
            </div>

            <div class="panel-body">
                @if($polls->count())
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Title</th> <th>Thumbnail</th> <th>Description</th> <th>Rules</th> <th>Category_id</th> <th>Vote_count</th> <th>Show_votecount</th> <th>Createuser_id</th> <th>Verifyuser_id</th> <th>Verifyflag</th> <th>Endflag</th> <th>Delflag</th>
                                <th class="text-right">OPTIONS</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($polls as $poll)
                                <tr>
                                    <td class="text-center"><strong>{{$poll->id}}</strong></td>

                                    <td>{{$poll->title}}</td> <td>{{$poll->thumbnail}}</td> <td>{{$poll->description}}</td> <td>{{$poll->rules}}</td> <td>{{$poll->category_id}}</td> <td>{{$poll->vote_count}}</td> <td>{{$poll->show_votecount}}</td> <td>{{$poll->createuser_id}}</td> <td>{{$poll->verifyuser_id}}</td> <td>{{$poll->verifyflag}}</td> <td>{{$poll->endflag}}</td> <td>{{$poll->delflag}}</td>
                                    
                                    <td class="text-right">
                                        <a class="btn btn-xs btn-primary" href="{{ route('polls.show', $poll->id) }}">
                                            <i class="glyphicon glyphicon-eye-open"></i> 
                                        </a>
                                        
                                        <a class="btn btn-xs btn-warning" href="{{ route('polls.edit', $poll->id) }}">
                                            <i class="glyphicon glyphicon-edit"></i> 
                                        </a>

                                        <form action="{{ route('polls.destroy', $poll->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                            {{csrf_field()}}
                                            <input type="hidden" name="_method" value="DELETE">

                                            <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $polls->render() !!}
                @else
                    <h3 class="text-center alert alert-info">Empty!</h3>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
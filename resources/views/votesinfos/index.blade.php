@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-align-justify"></i> voteInfo
                    <a class="btn btn-success pull-right" href="{{ route('voteInfos.create') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
                </h1>
            </div>

            <div class="panel-body">
                @if($voteInfos->count())
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>
Vote_id</th> <th>Info</th> <th>Thumbnail</th>
                                <th class="text-right">OPTIONS</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($voteInfos as $voteInfo)
                                <tr>
                                    <td class="text-center"><strong>{{$voteInfo->id}}</strong></td>

                                    <td>{{$voteInfo->
vote_id}}</td> <td>{{$voteInfo->info}}</td> <td>{{$voteInfo->thumbnail}}</td>

                                    <td class="text-right">
                                        <a class="btn btn-xs btn-primary" href="{{ route('voteInfos.show', $voteInfo->id) }}">
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>

                                        <a class="btn btn-xs btn-warning" href="{{ route('voteInfos.edit', $voteInfo->id) }}">
                                            <i class="glyphicon glyphicon-edit"></i>
                                        </a>

                                        <form action="{{ route('voteInfos.destroy', $voteInfo->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                            {{csrf_field()}}
                                            <input type="hidden" name="_method" value="DELETE">

                                            <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $voteInfos->render() !!}
                @else
                    <h3 class="text-center alert alert-info">Empty!</h3>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
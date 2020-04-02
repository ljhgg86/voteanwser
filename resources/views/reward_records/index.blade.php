@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-align-justify"></i> RewardRecord
                    <a class="btn btn-success pull-right" href="{{ route('reward_records.create') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
                </h1>
            </div>

            <div class="panel-body">
                @if($reward_records->count())
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>
Reward_id</th> <th>User_id</th> <th>Reward_type</th> <th>Redeemflag</th> <th>Redeem_at</th> <th>Vote_id</th> <th>Remark</th>
                                <th class="text-right">OPTIONS</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($reward_records as $reward_record)
                                <tr>
                                    <td class="text-center"><strong>{{$reward_record->id}}</strong></td>

                                    <td>{{$reward_record->
reward_id}}</td> <td>{{$reward_record->user_id}}</td> <td>{{$reward_record->reward_type}}</td> <td>{{$reward_record->redeemflag}}</td> <td>{{$reward_record->redeem_at}}</td> <td>{{$reward_record->vote_id}}</td> <td>{{$reward_record->remark}}</td>
                                    
                                    <td class="text-right">
                                        <a class="btn btn-xs btn-primary" href="{{ route('reward_records.show', $reward_record->id) }}">
                                            <i class="glyphicon glyphicon-eye-open"></i> 
                                        </a>
                                        
                                        <a class="btn btn-xs btn-warning" href="{{ route('reward_records.edit', $reward_record->id) }}">
                                            <i class="glyphicon glyphicon-edit"></i> 
                                        </a>

                                        <form action="{{ route('reward_records.destroy', $reward_record->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                            {{csrf_field()}}
                                            <input type="hidden" name="_method" value="DELETE">

                                            <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $reward_records->render() !!}
                @else
                    <h3 class="text-center alert alert-info">Empty!</h3>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
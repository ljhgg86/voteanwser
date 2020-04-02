<?php

namespace App\Http\Controllers;

use App\Models\VoteInfo;
use App\Models\Vote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\VoteInfoRequest;
use App\Http\Resources\VoteInfoResource;

class VoteInfosController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Vote $vote)
    {
        $voteInfos = VoteInfo::where('vote_id', $vote->id)
            ->orderBy('id', 'asc')
            ->with('vote', 'vote.options')
            ->get();

        if ($voteInfos->count()==0){
            return response()->json([
                'status' => false,
                'data'=>[],
                'message' => '访问对象不存在',
            ])->setStatusCode(400);
        }

        return response()->json([
            'status' => true,
            'data'=> VoteInfoResource::collection($voteInfos),
            'message' => '成功',
        ])->setStatusCode(200);
    }

    public function voteInfos(VoteInfoRequest $request, Vote $vote)
    {
        $this->authorize();

        $voteInfos = VoteInfo::where('vote_id', $vote->id)
            ->orderBy('id', 'asc')
            ->paginate($request->per_page);

        $count=VoteInfo::where('vote_id', $vote->id)->count();

        if ($count==0){
            return response()->json([
                'status' => false,
                'data'=> [],
                'message' => '访问对象不存在',
            ])->setStatusCode(400);
        }

        return response()->json([
            'status' => true,
            'data'=> VoteInfoResource::collection($voteInfos),
            'totalpage' => floor(($count+$request->per_page-1)/$request->per_page),
            'message' => '成功',
        ])->setStatusCode(200);
    }

    public function show(Vote $vote, VoteInfo $voteInfo)
    {
        $voteInfo = VoteInfo::where('id', $voteInfo->id)
            ->with('vote', 'vote.options')
            ->first();

        return response()->json([
           'status' => true,
           'data'=> new VoteInfoResource($voteInfo),
           'message' => '成功',
        ])->setStatusCode(200);
    }


    public function store(VoteInfoRequest $request, Vote $vote)
    {
        $this->authorize();

        $voteInfo = VoteInfo::make($request->all());

        $vote->voteInfos()->save($voteInfo);

        return response()->json([
            'status' => true,
            'data'=> new VoteInfoResource($voteInfo),
            'message' => '成功',
        ])->setStatusCode(200);
    }

    public function edit(Vote $vote, VoteInfo $voteInfo)
    {
        $this->authorize();

        return response()->json([
            'status' => true,
            'data'=> new VoteInfoResource($voteInfo),
            'message' => '成功',
        ])->setStatusCode(200);
    }

    public function update(VoteInfoRequest $request, Vote $vote, VoteInfo $voteInfo)
    {
        $this->authorize();

        $voteInfo->update($request->all());

        return response()->json([
            'status' => true,
            'data'=> new VoteInfoResource($voteInfo),
            'message' => '成功',
        ])->setStatusCode(200);
    }

	public function destroy(Vote $vote, VoteInfo $voteInfo)
    {
        $this->authorize();
        $voteInfo->delete();

        return response()->json([
            'status' => true,
            'data'=>[],
            'message' => '删除成功',
        ])->setStatusCode(200);
    }

    public function batSave(VoteInfoRequest $request, Vote $vote)
    {
        //数据格式 [{"id": 0, "info":"a", "thumbnail": "a.jpg", "statusflag":0} , {"id": 0, "info":"b", "thumbnail": "b.jpg", "statusflag":0}, {"id": 0, "info":"c", "thumbnail": "c.jpg", "statusflag":0} , {"id": 0, "info":"d", "thumbnail": "d.jpg", "statusflag":0}]
        $this->authorize();

        $voteInfos=collect(json_decode($request->votesinfo));

        if ($voteInfos->isEmpty())
        {
           return response()->json([
                'status' => false,
                'data'=>[
                    'successflag' => false,
                ],
                'message' => '数据格式错误，请重新输入！',
            ])->setStatusCode(400);
        }

        $voteInfos->each(function($voteInfo) use ($vote) {
            if ($voteInfo->statusflag==2) {
                //delete
                if ($voteInfo->id) {
                    VoteInfo::where('id', $voteInfo->id)->delete();
                }
            } else if ($voteInfo->statusflag==1) {
                //update
                if ($voteInfo->id) {
                    if (($voteInfo->info) || ($voteInfo->thumbnail)) {
                        $vi=VoteInfo::find($voteInfo->id);
                        $vi->info=$voteInfo->info;
                        $vi->thumbnail=$voteInfo->thumbnail;
                        $vi->save();
                    }
                }
            } else if ($voteInfo->statusflag==0) {
                //insert
                if (($voteInfo->info) || ($voteInfo->thumbnail)) {
                   VoteInfo::create(['vote_id'=>$vote->id,'info'=>$voteInfo->info, 'thumbnail'=> $voteInfo->thumbnail]);
                }
            }
        });

        return response()->json([
                'status' => true,
                'data'=>[
                    'successflag' => true,
                ],
                'message' => '批量数据添加成功！'
        ])->setStatusCode(200);
    }

}
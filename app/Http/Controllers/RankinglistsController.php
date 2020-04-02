<?php

namespace App\Http\Controllers;

use App\Models\Rankinglist;
use App\Models\Poll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RankinglistRequest;

class RankinglistsController extends Controller
{

	public function index()
	{
		$rankinglist=Rankinglist::find($request->min_id);

        $count = 0;
        if ($rankinglist) {
            $count=Rankinglist::where('poll_id', $poll->id)
                ->Where(function ($query) use ($rankinglist) {
                    $query->where('correct_num', '>', $rankinglist->correct_num)
                        ->orWhere(function ($query) use ($rankinglist) {
                            $query->where('correct_num', $rankinglist->correct_num)
                                ->where('last_correct_time', '<', $rankinglist->last_correct_time);
                        })->orWhere(function ($query) use ($rankinglist) {
                            $query->where('correct_num', $rankinglist->correct_num)
                            ->where('last_correct_time', $rankinglist->last_correct_time)
                            ->where('id', '<', $rankinglist->id);
                        });
                })
                ->count()+1;

            // $page=floor($count/$request->listcount);
        }

        $rankinglists = Rankinglist::where('poll_id', $poll->id)
                ->orderBy('correct_num', 'desc')
                ->orderBy('last_correct_time', 'asc')
                ->orderBy('id', 'desc')
                ->with('poll', 'user')
                ->skip($count)->take($request->listcount)
                ->get();

        if ($rankinglists->isEmpty()){
            return response()->json([
                'status' => false,
                'data'=> [],
                'message' => '访问对象不存在',
            ])->setStatusCode(400);
        }

        return response()->json([
            'status' => true,
            'data'=>$rankinglists,
            'message' => '成功',
        ])->setStatusCode(200);
	}

    public function show(Rankinglist $rankinglist)
    {
        $rankinglist = Rankinglist::where('id', $rankinglist->id)
            ->with('poll', 'user')
            ->first();
        return response()->json([
            'status' => true,
            'data'=> $rankinglist,
            'message' => '成功',
        ])->setStatusCode(200);
    }

	public function store(RankinglistRequest $request)
	{
		$this->authorize();

        $rankinglist = Rankinglist::create($request->all());

        return response()->json([
            'status' => true,
            'data'=> $rankinglist,
            'message' => '成功',
        ])->setStatusCode(200);
	}

	public function edit(Rankinglist $rankinglist)
	{
        $this->authorize();
        $rankinglist = Rankinglist::where('id', $rankinglist->id)
            ->with('poll', 'user')
            ->first();
        return response()->json([
            'status' => true,
            'data'=> $rankinglist,
            'message' => '成功',
        ])->setStatusCode(200);
	}

	public function update(RankinglistRequest $request, Rankinglist $rankinglist)
	{
		$this->authorize();

        $rankinglist->update($request->all());

        return response()->json([
            'status' => true,
            'data'=> $rankinglist,
            'message' => '成功',
        ])->setStatusCode(200);
	}

	public function destroy(Rankinglist $rankinglist)
	{
		$this->authorize();
        $rankinglist->delete();

        return response()->json([
            'status' => true,
            'data'=>[],
            'message' => '删除成功',
        ])->setStatusCode(200);
	}

    public function rankingList(RankinglistRequest $request, Poll $poll)
    {

        $rankinglist=Rankinglist::find($request->min_id);

        $count = 0;

        if ($rankinglist) {
             $count=Rankinglist::where('poll_id', $poll->id)
                ->Where(function ($query) use ($rankinglist) {
                    $query->where('correct_num', '>', $rankinglist->correct_num)
                        ->orWhere(function ($query) use ($rankinglist) {
                            $query->where('correct_num', $rankinglist->correct_num)
                                ->where('last_correct_time', '<', $rankinglist->last_correct_time);
                        })->orWhere(function ($query) use ($rankinglist) {
                            $query->where('correct_num', $rankinglist->correct_num)
                            ->where('last_correct_time', $rankinglist->last_correct_time)
                            ->where('id', '<', $rankinglist->id);
                        });
                })
                ->count()+1;

            // $page=floor($count/$request->listcount);
        }

        $rankinglists = Rankinglist::where('poll_id', $poll->id)
                ->orderBy('correct_num', 'desc')
                ->orderBy('last_correct_time', 'asc')
                ->orderBy('id', 'asc')
                ->with('poll', 'user')
                ->skip($count)->take($request->listcount)
                ->get();


        if ($rankinglists->isEmpty()){
            return response()->json([
                'status' => false,
                'data'=> [],
                'message' => '访问对象不存在',
            ])->setStatusCode(400);
        }
        return response()->json([
            'status' => true,
            'data'=>$rankinglists,
            'message' => '成功',
        ])->setStatusCode(200);
    }
}
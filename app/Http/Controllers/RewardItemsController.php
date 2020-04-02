<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\RewardItem;
use App\Models\RewardRecord;
use App\Http\Requests\RewardItemRequest;

class RewardItemsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(RewardItemRequest $request, Reward $reward)
	{
		$rewardItems = RewardItem::where('reward_id', $reward->id)
            ->orderBy('id', 'desc')
            ->with('reward', 'poll', 'vote')
            ->paginate($request->per_page);

        $count=RewardItem::where('reward_id', $reward->id)
            ->count();

        if ($count==0){
            return response()->json([
                'status' => false,
                'data'=> [],
                'message' => '访问对象不存在',
            ])->setStatusCode(400);
        }

        return response()->json([
            'status' => true,
            'data'=> $rewardItems,
            'totalpage' => floor(($count+$request->per_page-1)/$request->per_page),
            'message' => '成功',
        ])->setStatusCode(200);
	}

    public function show(Reward $reward, RewardItem $reward_item)
    {
        $rewardItem = RewardItem::where('id', $reward_item->id)
            ->with('reward', 'poll', 'vote')
            ->first();

        return response()->json([
           'status' => true,
           'data'=> $rewardItem,
           'message' => '成功',
        ])->setStatusCode(200);
    }

	public function store(RewardItemRequest $request, Reward $reward)
	{
		$this->authorize();

        $rewardItem = RewardItem::make($request->all());

        $Reward->rewardItems()->save($rewardItem);

        return response()->json([
            'status' => true,
            'data'=> $rewardItem,
            'message' => '成功',
        ])->setStatusCode(200);
	}

    public function batSave(RewardItemRequest $request, Reward $reward)
    {
        //数据格式 reward_items=>[{"id": 0, "poll_id":1, "vote_id": 1, "statusflag":0} , {"id": 0, "poll_id":1, "vote_id": 2, "statusflag":0}]
        $this->authorize();

        $rewardItems=collect(json_decode($request->reward_items));

        if ($rewardItems->isEmpty())
        {
           return response()->json([
                'status' => false,
                'data'=>[
                    'successflag' => false,
                ],
                'message' => '数据格式错误，请重新输入！',
            ])->setStatusCode(400);
        }

        if ($this->existRecord($reward)) {
           return response()->json([
            'status' => false,
            'data'=>[],
            'message' => '存在抽奖数据，无法进行修改',
           ])->setStatusCode(400);
        }

        $rewardItems->each(function($rewardItem) use ($reward) {
            if ($rewardItem->statusflag==2) {
                //delete

                if ($rewardItem->id) {
                    RewardItem::where('id', $rewardItem->id)->delete();
                }
            } else if ($rewardItem->statusflag==1) {
                //update
                if ($rewardItem->id) {
                    if ($rewardItem->vote_id) {
                        $ri=RewardItem::find($rewardItem->id);
                        $ri->poll_id=$rewardItem->poll_id;
                        $ri->vote_id=$rewardItem->vote_id;
                        $ri->save();
                    }
                }
            } else if ($rewardItem->statusflag==0) {
                //insert
                if (($rewardItem->vote_id)) {
                   RewardItem::firstOrCreate(['reward_id'=>$reward->id, 'poll_id'=>$rewardItem->poll_id,'vote_id'=>$rewardItem->vote_id]);
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

	public function edit(Reward $reward, RewardItem $reward_item)
	{
        $this->authorize();

        return response()->json([
            'status' => true,
            'data'=> $reward_item,
            'message' => '成功',
        ])->setStatusCode(200);
	}

	public function update(RewardItemRequest $request, Reward $reward, RewardItem $reward_item)
	{
		$this->authorize();

        $reward_item->update($request->all());

        return response()->json([
            'status' => true,
            'data'=> $reward_item,
            'message' => '成功',
        ])->setStatusCode(200);
	}

	public function destroy(Reward $reward, RewardItem $reward_item)
	{
		$this->authorize();
        if ($this->existRecord($reward)) {
           return response()->json([
            'status' => false,
            'data'=>[],
            'message' => '存在抽奖数据，删除失败',
           ])->setStatusCode(400);
        }
        $reward_item->delete();

        return response()->json([
            'status' => true,
            'data'=>[],
            'message' => '删除成功',
        ])->setStatusCode(200);
	}

    public function existRecord(Reward $reward)
    {
        $isExist=false;
        $rewardRecords = RewardRecord::where('reward_id', $reward->id)->get();
        if ($rewardRecords->isNotEmpty()) {
            $isExist=true;
        }
        return $isExist;
    }
}
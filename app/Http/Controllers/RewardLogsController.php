<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\RewardLog;
use App\Http\Requests\RewardLogRequest;

class RewardLogsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(RewardLogRequest $request, Reward $reward)
    {
        $rewardLogs = RewardLog::where('reward_id', $reward->id)
            ->orderBy('id', 'desc')
            ->with('reward', 'user')
            ->paginate($request->per_page);

        $count=RewardLog::where('reward_id', $reward->id)
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
            'data'=> $rewardLogs,
            'totalpage' => floor(($count+$request->per_page-1)/$request->per_page),
            'message' => '成功',
        ])->setStatusCode(200);
    }

    public function show(Reward $reward, RewardLog $reward_log)
    {
        $reward_log = RewardItem::where('id', $reward_log->id)
            ->with('reward', 'user')
            ->first();

        return response()->json([
           'status' => true,
           'data'=> $reward_log,
           'message' => '成功',
        ])->setStatusCode(200);
    }

	public function store(RewardLogRequest $request, Reward $reward)
	{
		$this->authorize();

        $reward_log = RewardLog::make($request->all());

        $Reward->rewardLogs()->save($reward_log);

        return response()->json([
            'status' => true,
            'data'=> $reward_log,
            'message' => '成功',
        ])->setStatusCode(200);
	}

	public function edit(Reward $reward, RewardLog $reward_log)
    {
        $this->authorize();

        return response()->json([
            'status' => true,
            'data'=> $reward_log,
            'message' => '成功',
        ])->setStatusCode(200);
    }

	public function update(RewardLogRequest $request, Reward $reward, RewardLog $reward_log)
	{
		$this->authorize();
		$reward_log->update($request->all());

        return response()->json([
            'status' => true,
            'data'=> $reward_log,
            'message' => '成功',
        ])->setStatusCode(200);
	}

	public function destroy(Reward $reward, RewardLog $reward_log)
    {
        $this->authorize();
        $reward_log->delete();

        return response()->json([
            'status' => true,
            'data'=>[],
            'message' => '删除成功',
        ])->setStatusCode(200);
    }
}
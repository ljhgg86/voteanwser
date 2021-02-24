<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\RewardRecord;
use App\Models\RewardLog;
use App\Models\RewardItem;
use App\Models\Poll;
use App\Models\Vote;
use App\Models\Option;
use App\Models\Answer;
use App\Models\User;
use App\Models\UserVote;
use App\Models\Rankinglist;
use App\Http\Requests\RewardRequest;

class RewardsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(RewardRequest $request)
    {
        $rewards = Reward::where('delflag', false)
            ->orderBy('id', 'desc')
            ->paginate($request->per_page);

        $count=Reward::where('delflag',false)->count();

        if ($count==0){
            return response()->json([
                'status' => false,
                'data'=> [],
                'message' => '访问对象不存在',
            ])->setStatusCode(400);
        }

        return response()->json([
            'status' => true,
            'data'=> $rewards,
            'totalpage' => floor(($count+$request->per_page-1)/$request->per_page),
            'message' => '成功',
        ])->setStatusCode(200);
    }

    public function show(Reward $reward)
    {
        return response()->json([
            'status' => true,
            'data'=> $reward,
            'message' => '成功',
        ])->setStatusCode(200);
    }

	public function store(RewardRequest $request)
	{
		$this->authorize();

        $reward = Reward::create($request->all());

        return response()->json([
            'status' => true,
            'data'=> $reward,
            'message' => '成功',
        ])->setStatusCode(200);
	}

	public function edit(Reward $reward)
	{
        $this->authorize();

        if ($reward->delflag){
            return response()->json([
                'status' => false,
                'data'=>[],
                'message' => '访问对象不存在',
            ])->setStatusCode(400);
        }

        return response()->json([
            'status' => true,
            'data'=> $reward,
            'message' => '成功',
        ])->setStatusCode(200);
	}

	public function update(RewardRequest $request, Reward $reward)
	{
		$this->authorize();

        $reward->update($request->all());

        return response()->json([
            'status' => true,
            'data'=> $reward,
            'message' => '成功',
        ])->setStatusCode(200);
	}

	public function destroy(Reward $reward)
	{
		$this->authorize();

        $reward->delflag = true;
        $reward->save();

        return response()->json([
            'status' => true,
            'data'=>[],
            'message' => '删除成功',
        ])->setStatusCode(200);
	}

    public function reward(RewardRequest $request, Reward $reward)
    {
        $this->authorize();
        //获得输入，保存rewardLog
        $reward_type = $request->reward_type;
        $reward_count = $request->reward_count;
        if (($reward_type) && ($reward_count>0)) {
            //获得输入，保存rewardLog
            $reward_log = RewardLog::make($request->all());
            $reward_log->user_id = $request->user()->id;
            $reward->rewardLogs()->save($reward_log);
        } else {
            return response()->json([
                'status' => false,
                'data'=>[],
                'message' => '输入参数错误，请重新输入',
            ])->setStatusCode(400);
        }
        //获取rewardrecord
        $rewardRecords = RewardRecord::where('reward_id', $reward->id)->where('reward_type', $reward_type)->get();
        if ($rewardRecords->isNotEmpty()) {
            return response()->json([
                'status' => false,
                'data'=>[],
                'message' => '该奖项抽奖数据已存在，请重新输入',
            ])->setStatusCode(400);
        }
        //获取已获奖的user_id
        $redeem_user_ids = RewardRecord::where('reward_id', $reward->id)->get()->pluck('user_id');

        //获取rewarditem
        $vote_ids = RewardItem::where('reward_id', $reward->id)->get()->pluck('vote_id');


        $vote_user_id = collect([]);

        //查看投票条目是否有答案
        if ($reward->condition>0) {
                $min_count=$vote_ids->count()-$reward->condition;
                //获取vote的answers vote_id=>"option_id,option_id..."
                $answer_ids=Answer::whereIn('vote_id', $vote_ids)->select('vote_id', 'option_id')->get()->mapToGroups(function($item, $key) {return [$item['vote_id'] => $item['option_id']];})->map(function($item, $key) {return collect($item)->implode(',');});

                //所有用户的投票列表 user_id=>vote_id=>"option_id,option_id..."
                $userVote_ids = UserVote::whereIn('vote_id',$vote_ids)->where('correct', true)->whereNotIn('user_id', $redeem_user_ids)->select('user_id','vote_id', 'option_id')->get()->mapToGroups(function($item, $key) {return [$item['user_id'] => ['vote_id'=>$item['vote_id'],'option_id'=>$item['option_id']]];})->map(function($item, $key) {
                        return $item->mapToGroups(function($item, $key) {
                            return [$item['vote_id'] => $item['option_id']];
                        })->map(function($item, $key) {
                            return collect($item)->implode(',');
                        });
                    });

                $vote_user_id = $userVote_ids->map(function($item,$key) use ($answer_ids,$min_count) {
                    //迭代用户投票列表，用户的投票列表和答案进行diffAssoc的出答错的数量
                    if ($min_count>=$answer_ids->diffAssoc($item)->count()) {
                        return $key;
                    }
                })->reject(function ($user_id) {
                    return empty($user_id);
                });

        } else {
            $vote_user_id = UserVote::whereIn('vote_id', $vote_ids)
                        ->whereNotIn('user_id', $redeem_user_ids)
                        ->get()->pluck('user_id');
        }

        $reedem_ids=$vote_user_id->random($reward_count);

        $reedem_ids->each(function($reedem_id) use ($reward, $reward_type) {
            RewardRecord::create([
                'reward_id'=>$reward->id,
                'user_id'=>$reedem_id,
                'reward_type'=>$reward_type,
            ]);
        });
        return response()->json([
                'status' => true,
                'data'=>[],
                'message' => '该奖项抽奖成功',
            ])->setStatusCode(200);
        /*比较，
        1.选出答对符合条件的用户
        2.剔除已经抽奖过的用户
        3.随机抽出指定数量的用户
        */

    }
    public function rewards(RewardRequest $request, Reward $reward){
        $this->authorize();
        $reward_type = $request->reward_type;
        $reward_count = $request->reward_count;
        if (($reward_type) && ($reward_count>0)) {
            //获得输入，保存rewardLog
            $reward_log = RewardLog::make($request->all());
            $reward_log->user_id = $request->user()->id;
            $reward->rewardLogs()->save($reward_log);
        } else {
            return response()->json([
                'status' => false,
                'data'=>[],
                'message' => '输入参数错误，请重新输入',
            ])->setStatusCode(400);
        }
         //获取rewardrecord
         $rewardRecords = RewardRecord::where('reward_id', $reward->id)->where('reward_type', $reward_type)->get();
         if ($rewardRecords->isNotEmpty()) {
             return response()->json([
                 'status' => false,
                 'data'=>[],
                 'message' => '该奖项抽奖数据已存在，请重新输入',
             ])->setStatusCode(400);
         }

         //获取poll_id
        $poll_id = RewardItem::where('reward_id', $reward->id)->first()->poll_id;

        //获取poll_id对应的所有reward_id
        $reward_ids = RewardItem::where('poll_id', $poll_id)->get()->pluck('reward_id');

         //获取已获奖的user_id
        //$redeem_user_ids = RewardRecord::where('reward_id', $reward->id)->get()->pluck('user_id');
        $redeem_user_ids = RewardRecord::whereIn('reward_id', $reward_ids)->get()->pluck('user_id');
 
        //for亚青start,新增只找地址不为空的
        // $user_ids = User::whereNotNull('address')->get()->pluck('id');
       
        // $vote_user_ids = Rankinglist::where('poll_id', $poll_id)
        //                             ->whereNotIn('user_id', $redeem_user_ids)
        //                             ->whereIn('user_id', $user_ids)
        //                             ->where('correct_num','>=',$reward->condition)
        //                             ->get()
        //                             ->pluck('user_id');
         //for亚青end

        $vote_user_ids = Rankinglist::where('poll_id', $poll_id)
                                    ->whereNotIn('user_id', $redeem_user_ids)
                                    ->where('correct_num','>=',$reward->condition)
                                    ->get()
                                    ->pluck('user_id');
        if($vote_user_ids->isEmpty()){
            return response()->json([
                'status'=>false,
                'data'=>[],
                'message'=>"没有符合条件的用户"
            ])->setStatusCode(400);
        }

        //for 亚青
        //$user_ids = User::whereNotNull('address')->get(['id']);
        //$vote_user_ids = $vote_user_ids->intersect($user_ids);
        //for 亚青

        $reedem_ids = $vote_user_ids->count() > $reward_count ? $vote_user_ids->random($reward_count) : $vote_user_ids;

        $reedem_ids->each(function($reedem_id) use ($reward, $reward_type) {
            RewardRecord::create([
                'reward_id'=>$reward->id,
                'user_id'=>$reedem_id,
                'reward_type'=>$reward_type,
            ]);
        });
        return response()->json([
                'status' => true,
                'data'=>[],
                'message' => '该奖项抽奖成功',
            ])->setStatusCode(200);
    }
}
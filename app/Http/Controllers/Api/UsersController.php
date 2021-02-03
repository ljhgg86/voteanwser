<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Proxy\TokenProxy;
use App\Models\SmsRecord;
use App\Models\User;

use App\Models\Poll;
use App\Models\Vote;
use App\Models\UserVote;
use App\Models\Option;
use App\Models\Rankinglist;

use App\Models\Reward;
use App\Models\RewardRecord;

class UsersController extends Controller
{

    protected $proxy;

    public function __construct(TokenProxy $proxy)
    {
        $this->proxy = $proxy;
    }

    public function register(VerificationCodeRequest $request)
    {

        $smsRecord=SmsRecord::where('name',$request->name)->where('expired_at','>=',now())->first();

        if (!$smsRecord) {
            return response()->json([
                'status' => false,
                'data'=>[
                    'successflag' => false,
                ],
                'message' => '验证码已失效',
            ])->setStatusCode(422);
        }

        if (!hash_equals($smsRecord->verification_code, $request->password)) {

            return response()->json([
                'status' => false,
                'data'=>[
                    'successflag' => false,
                ],
                'message' => '验证码错误',
            ])->setStatusCode(401);

        }

        $user = User::create([
            'name' => $request->name,
            'password' => bcrypt($request->verification_code),
        ]);

        return $this->proxy->login($request->name, $request->password);
    }

    public function authUser(Request $request)
    {
        $user= $request->user();

        return response()->json([
            'status' => true,
            'data'=>$user,
            'message' => '成功',
        ])->setStatusCode(200);
    }

    public function update(Request $request)
    {
        $user= $request->user();

        if (is_null($user)) {
             return response()->json([
                'status'=>false,
                'data'=>[
                    'successflag'=>false,
                ],
                'message'=>'用户不存在',
            ], 400);
        }

        if ($request->has('realname')) {
            $user->realname=$request->realname;
        }
        if ($request->has('nickname')) {
            $user->nickname=$request->nickname;
        }
        if ($request->has('phone')) {
            $user->phone=$request->phone;
        }
        if ($request->has('user_avatar')) {
            $user->user_avatar=$request->user_avatar;
        }
        if($request->has('address')){
            $user->address = $request->address;
        }

        $user->save();

        return response()->json([
            'status' => true,
            'data'=>$user,
            'message' => '用户资料更新成功',
        ])->setStatusCode(201);
    }

    public function allVotes(Request $request)
    {
        //用户投票列表
        $user = $request->user();

        $uvs=$user->userVotes;

        $uvs->map(function($uv) {
            $option=Option::find($uv->option_id);
            $uv->option=$option->option;
            $uv->description=$option->description;
            $uv->thumbnail=$option->thumbnail;
            unset($uv->user_id);
            return $uv;
        });

        $voteIds=$uvs->pluck('vote_id');

        $votes=Vote::whereIn('id', $voteIds)->get();

        $votes->map(function($vote) use ($uvs) {
            $ps=collect([]);
            $uvs->map(function($uv) use ($vote, $ps) {
                if ($vote->id == $uv->vote_id) {
                   $ps->push($uv);
                }
            });
            return $vote->options=$ps;
        });

        $pollIds=$votes->pluck('poll_id');

        $polls=Poll::whereIn('id', $pollIds)->get();

        $polls->map(function($poll) use ($votes) {
            $vs=collect([]);
            $votes->map(function($vote) use ($poll, $vs) {
                if ($poll->id == $vote->poll_id) {
                   $vs->push($vote);
                }
            });

            return $poll->votes=$vs;
        });

        return $polls;
    }

    public function votes(Request $request, Poll $poll)
    {
        $voteIds=$poll->votes->pluck('id');

        //用户投票列表
        $user = $request->user();

        $userVotes = UserVote::whereIn('vote_id',$voteIds)
                            ->where('correct', true)
                            ->select('vote_id','option_id')
                            ->get()->groupBy('vote_id')
                            ->map(function($userVote) {
                                return $userVote->pluck('option_id');
                            });
      //  return $userVotes;

        $uvs=UserVote::whereIn('vote_id', $voteIds)
                    ->where('user_id', $user->id)
                    ->get();

        $vids=$uvs->pluck('vote_id');
        $oids=$uvs->pluck('option_id');

        $votes=Vote::whereIn('id', $vids)->with('options','voteInfos')->get();

        $votes->map(function($vote) use ($oids, $userVotes) {

            $answer_ids=$vote->answers()->pluck('option_id');

            $option_ids=$userVotes->get($vote->id);
            $vote->user_winflag=false;

            if ($answer_ids->diff($option_ids)->isEmpty()) {
                $vote->user_winflag=true;
            }

            $options = $vote->options;
            $options->map(function($option) use ($oids) {
                if ($oids->search($option->id)===false) {
                    $option->user_selected = false;
                }else {
                    $option->user_selected = true;
                }
                return $option;
            });
            return $vote;
        });
        return $votes;


        if ($votes->isEmpty()) {
            return response()->json([
                'status' => false,
                'data'=>[],
                'message' => '访问对象不存在',
            ])->setStatusCode(400);
        }

        return response()->json([
           'status' => true,
           'data'=> $votes,
           'message' => '成功',
        ])->setStatusCode(200);
    }

    public function ranking(Request $request, Poll $poll)
    {
        $user = $request->user();

        $rankinglist = Rankinglist::where('poll_id', $poll->id)
                    ->where('user_id', $user->id)
                    ->first();

        if (!$rankinglist){
            return response()->json([
                'status' => false,
                'data'=> [],
                'message' => '访问对象不存在',
            ])->setStatusCode(400);
        }

        $rankingnum = Rankinglist::where('poll_id', $poll->id)
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
                ->count();

        return response()->json([
            'status' => true,
            'data'=>[
                'correct_num' => $rankinglist->correct_num,
                'rankingnum' => $rankingnum+1
            ],
            'message' => '成功',
        ])->setStatusCode(200);
    }

    public function rewardRecord(Request $request, Reward $reward)
    {
        $user = $request->user();

        $rewardRecord = RewardRecord::where('reward_id', $reward->id)
                    ->where('user_id', $user->id)
                    ->where('delflag', false)
                    ->first();

        if (!$rewardRecord){
            return response()->json([
                'status' => false,
                'data'=> [],
                'message' => '访问对象不存在',
            ])->setStatusCode(400);
        }

        return response()->json([
            'status' => true,
            'data'=>$rewardRecord,
            'message' => '成功',
        ])->setStatusCode(200);
    }

    public function redeem(Request $request, Reward $reward)
    {
        $user = $request->user();

        $rewardRecord = RewardRecord::where('reward_id', $reward->id)
                    ->where('user_id', $user->id)
                    ->where('delflag', false)
                    ->first();

        if (!$rewardRecord){
            return response()->json([
                'status' => false,
                'data'=> [],
                'message' => '访问对象不存在',
            ])->setStatusCode(400);
        }

        $rewardRecord->redeemflag = true;
        $rewardRecord->save();

        return response()->json([
            'status' => true,
            'data'=>$rewardRecord,
            'message' => '兑奖成功',
        ])->setStatusCode(200);
    }

}

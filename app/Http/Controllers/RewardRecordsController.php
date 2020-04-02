<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\RewardRecord;
use App\Handlers\SmsUtil;
use App\Models\User;

use App\Http\Requests\RewardRecordRequest;

class RewardRecordsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth', ['except' => ['index', 'show']]);
    }


	public function index(RewardRecordRequest $request, Reward $reward)
    {
        $rewardRecords = RewardRecord::where('reward_id', $reward->id)
            ->orderBy('id', 'desc')
            ->with('reward', 'user')
            ->paginate($request->per_page);

        $count=RewardRecord::where('reward_id', $reward->id)
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
            'data'=> $rewardRecords,
            'totalpage' => floor(($count+$request->per_page-1)/$request->per_page),
            'message' => '成功',
        ])->setStatusCode(200);
    }

    public function show(Reward $reward, RewardRecord $reward_record)
    {
        $reward_record = RewardRecord::where('id', $reward_record->id)
            ->with('reward', 'user')
            ->first();

        return response()->json([
           'status' => true,
           'data'=> $reward_record,
           'message' => '成功',
        ])->setStatusCode(200);
    }

	public function store(RewardRecordRequest $request, Reward $reward)
	{
		$this->authorize();

        $reward_record = RewardRecord::make($request->all());

        $Reward->rewardRecords()->save($reward_record);

        return response()->json([
            'status' => true,
            'data'=> $reward_record,
            'message' => '成功',
        ])->setStatusCode(200);
	}

	public function edit(Reward $reward, RewardRecord $reward_record)
	{
        $this->authorize();

        return response()->json([
            'status' => true,
            'data'=> $reward_record,
            'message' => '成功',
        ])->setStatusCode(200);
	}

	public function update(RewardRecordRequest $request, Reward $reward, RewardRecord $reward_record)
	{
		$this->authorize();

        $reward_record->update($request->all());

        return response()->json([
            'status' => true,
            'data'=> $reward_record,
            'message' => '成功',
        ])->setStatusCode(200);
	}

	public function destroy(Reward $reward, RewardRecord $reward_record)
	{
		$this->authorize();

        $reward_record->delflag = true;
        $reward_record->save();

        return response()->json([
            'status' => true,
            'data'=>[],
            'message' => '删除成功',
        ])->setStatusCode(200);
	}
    //发送中奖短信 参数奖项
    public function sendSms(RewardRecordRequest $request, Reward $reward)
    {
        $this->authorize();

        $reward_records = RewardRecord::where('reward_id', $reward->id)
                    ->where('reward_type', $request->reward_type)
                    ->where('sendsms_flag', false)
                    -get();

        if ($reward_records->isEmpty())
        {
           return response()->json([
                'status' => false,
                'data'=>[
                    'successflag' => false,
                ],
                'message' => '访问对象不存在',
            ])->setStatusCode(400);
        }

        $smsUtil=new SmsUtil();

        $reward_records->each(function ($reward_record) use ($smsUtil) {

            // 生成8位随机数，左侧补0
            $redeem_code = str_pad(random_int(1, 99999999), 8, 0, STR_PAD_LEFT);
            $user=User::find($reward_record->user_id);
            //发送短信
            $result = $smsUtil->sendRewardSms($user->name, $redeem_code);

            if ($result->respCode ==='00000') {

                // 短信发送成功 修改 $reward_record
                $reward_record->update(['redeem_code'=>$redeem_code, 'sendsms_flag'=>true, 'sendsms_at'=>now()]);

            }  else {
                 // 短信发送失败 修改 $reward_record
                 $reward_record->update(['sendsms_flag'=>false, 'sendsms_at'=>now()]);

            }
        });

        return response()->json([
            'status' => true,
            'data'=>[],
            'message' => '短信发送成功',
        ])->setStatusCode(200);
    }
}
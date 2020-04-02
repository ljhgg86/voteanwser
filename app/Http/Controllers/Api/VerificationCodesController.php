<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\VerificationCodeRequest;
use App\Http\Requests\Api\LoginVerificationCodeRequest;
use App\Models\SmsRecord;
use App\Models\Inviterscore;

use App\Handlers\SmsUtil;
use App\Models\User;
Use Carbon\Carbon;

class VerificationCodesController extends Controller
{
    protected $smsUtil;

    public function __construct(SmsUtil $smsUtil)
    {
        $this->smsUtil = $smsUtil;
    }

    public function registerSms(VerificationCodeRequest $request)
    {
        $name = $request->name;

        $user=User::where('name',$name)->first();

        // if ($user) {
        //     return response()->json([
        //         'status' => false,
        //         'data'=>[
        //             'successflag' =>false
        //         ],
        //         'message' => '用户已存在',
        //     ])->setStatusCode(400);
        // }

        $beginAt = now()->addMinutes(-60);

        $sms_count=SmsRecord::where('name',$name)->where('created_at','>=', $beginAt)->get()->count();

        if ($sms_count>4) {
            return response()->json([
                'status' => false,
                'data'=>[
                    'successflag' => false
                ],
                'message' => '发送短信过于频繁，请60分钟后再试！',
            ])->setStatusCode(401);
        }

        // 生成6位随机数，左侧补0
        $code = str_pad(random_int(1, 999999), 6, 0, STR_PAD_LEFT);

        //发送短信
        $result = $this->smsUtil->sendSms($name, $code);

        if ($result->respCode ==='00000') {

            // 缓存验证码 2分钟过期。
            $expiredAt = now()->addDays(5);

            //save smsrecord
            $smsRecord=SmsRecord::create([
                'name' => $name,
                'verification_code'=>$code,
                'expired_at' => $expiredAt,
            ]);

            return response()->json([
                'status' => true,
                'data'=>[
                    'successflag' => true
                ],
                'message' => '发送短信成功',
            ])->setStatusCode(201);
        } else if ($result->respCode ==='00141') {
            return response()->json([
                'status' => false,
                'data' =>[
                    'successflag' =>false
                ],
                'message' => '一小时内发送给单个手机次数超过限制(4次).',
            ])->setStatusCode(401);
        } else {
            return response()->json([
                'status' => false,
                'data' =>[
                    'successflag' => false
                ],
                'message' => '发送短信失败',
            ])->setStatusCode(400);
        }

    }

    public function loginSms(LoginVerificationCodeRequest $request)
    {
        $name = $request->name;


        // if (!$user) {
        //     return response()->json([
        //         'status' => false,
        //         'data'=>[
        //             'successflag' =>false
        //         ],
        //         'message' => '用户不存在',
        //     ])->setStatusCode(400);
        // }

        $beginAt = now()->addMinutes(-60);

        $sms_count=SmsRecord::where('name',$name)->where('created_at','>=', $beginAt)->get()->count();
        if ($sms_count>4) {
            return response()->json([
                'status' => false,
                'data'=>[
                    'successflag' => false
                ],
                'message' => '发送短信过于频繁，请60分钟后再试！',
            ])->setStatusCode(401);
        }

        // 生成6位随机数，左侧补0
        $code = str_pad(random_int(1, 999999), 6, 0, STR_PAD_LEFT);

        //发送短信
        $result = $this->smsUtil->sendSms($name, $code);

        if ($result->respCode ==='00000') {

            // 缓存验证码 2分钟过期。
            $expiredAt = now()->addDays(5);

            //save smsrecord
            $smsRecord=SmsRecord::create([
                'name' => $name,
                'verification_code'=>$code,
                'expired_at' => $expiredAt,
            ]);

            $user=User::where('name', $name)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $request->name,
                    'password' => bcrypt($code),
                ]);
            } else {
                $user->update(['password'=>bcrypt($code)]);
            }

            return response()->json([
                'status' => true,
                'data'=>[
                    'successflag' =>true
                ],
                'message' => '发送短信成功',
            ])->setStatusCode(201);
        } else if ($result->respCode ==='00141') {
            return response()->json([
                'status' => false,
                'data' =>[
                    'successflag' =>false
                ],
                'message' => '一小时内发送给单个手机次数超过限制(4次).',
            ])->setStatusCode(401);
        } else {
            return response()->json([
                'status' => false,
                'data' =>[
                    'successflag' =>false
                ],
                'message' => '发送短信失败',
            ])->setStatusCode(400);
        }
    }
}

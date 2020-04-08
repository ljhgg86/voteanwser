<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Proxy\TokenProxy;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Models\SmsRecord;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $proxy;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TokenProxy $proxy)
    {
        $this->proxy = $proxy;
    }

    public function login()
    {
        $sms=SmsRecord::where('name',request('name'))
                        ->where('verification_code', request('password'))
                        ->orderBy('id','desc')
                        ->first();
        //dump("a1");
        // if (!$sms) {
        //     return response()->json([
        //         'status' => false,
        //         'data'=>[
        //             'successflag' => false
        //         ],
        //         'message' => '短信验证码错误！',
        //     ])->setStatusCode(400);
        // }

        //$current=now();

        // if ($sms->expired_at<now()) {
        //     return response()->json([
        //         'status' => false,
        //         'data'=>[
        //             'successflag' => false,
        //             'expired_at' => $sms->expired_at,
        //             'now' => $current

        //         ],
        //         'message' => '短信验证码已过期！',
        //     ])->setStatusCode(400);
        // }
        //dump("ddd");
        return $this->proxy->login(request('name'), request('password'), request('inviterid'));//add request inviter by 0.618
    }

    public function adminLogin()
    {
        return $this->proxy->login(request('name'), request('password'));
    }

    public function logout()
    {
        return $this->proxy->logout();
    }

    public function refresh()
    {
        return $this->proxy->refresh();
    }
}

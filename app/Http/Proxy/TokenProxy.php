<?php

namespace App\Http\Proxy;
use App\Models\User;
use App\Models\Inviterscore;
Use Carbon\Carbon;

class TokenProxy {

    protected $http;

    /**
     * TokenProxy constructor.
     * @param $http
     */

    public function __construct(\GuzzleHttp\Client $http)
    {
        $this->http = $http;
    }

    public function login($name, $password, $inviterid = 0)//add the 3rd parameter inviterid by 0.618
    {
        if (auth()->attempt(['name' => $name, 'password' => $password])) {
            //start add by 0.618
            $user = User::where('name',$name)->first();
            if(!($user->inviter) && $inviterid){
                User::where('name', $name)->update(['inviter'=>$inviterid]);
                Inviterscore::updateOrCreate(
                    ['inviter' => $inviterid],
                    ['update_time' => Carbon::now()]
                );
                Inviterscore::where('inviter', $inviterid)
                            ->increment('inviterscore');
            }
            //end
            return $this->proxy('password', [
                'username' => $name,
                'password' => $password,
                'scope'    => '',
            ]);
        }

        return response()->json([
            'status'  => false,
            'data'=>[
                'successflag'=>false,
            ],
            'message' => '登录信息不匹配',
        ], 421);
    }

    public function refresh()
    {
        $refreshToken = request()->cookie('refreshToken');

        return $this->proxy('refresh_token', [
            'refresh_token' => $refreshToken,
        ]);
    }

    public function logout()
    {
        $user = auth()->guard('api')->user();

        if (is_null($user)) {

            app('cookie')->queue(app('cookie')->forget('refreshToken'));

             return response()->json([
                'status'=>true,
                'data'=>[
                    'successflag'=>true,
                ],
                'message'=>'退出登录成功',
            ], 204);
        }

        $accessToken = $user->token();

        app('db')->table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true,
            ]);

        app('cookie')->queue(app('cookie')->forget('refreshToken'));

        $accessToken->revoke();

        return response()->json([
            'status'=>true,
            'data'=>[
                'successflag'=>true,
            ],
            'message'=>'退出登录成功',
        ], 204);

    }

    public function proxy($grantType, array $data = [])
    {
        $data = array_merge($data, [
            'client_id'     => env('PASSPORT_CLIENT_ID'),
            'client_secret' => env('PASSPORT_CLIENT_SECRET'),
            'grant_type'    => $grantType,
        ]);

        $response = $this->http->post(env('APP_URL').'/oauth/token', [
            'form_params' => $data,
        ]);

        $token = json_decode((string)$response->getBody(), true);

        return response()->json([
            'status'=>true,
            'data'=>[
                'successflag' => true,
                'access_token' => $token['access_token'],
                'auth_id'    => md5($token['refresh_token']),
                'expires_in' => $token['expires_in'],
            ],
            'message'=>'成功',

        ], 200)->cookie('refreshToken', $token['refresh_token'], 14400, null, null, false, true);
    }
}
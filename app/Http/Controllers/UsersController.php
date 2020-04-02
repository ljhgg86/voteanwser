<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Option;

use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    public function voted(Option $option)
    {

        $user=request()->user();
        // $user=User::find(1);

        if (!$user) {
            return response()->json([
                'status' => false,
                'data'=>[
                    'successflag' => false,
                ],
                'message' => '用户未登录',
            ])->setStatusCode(400);
        }

        if ($user->options->pluck('vote_id')->contains($option->vote_id)) {

            return response()->json([
                'status' => false,
                'data'=>[
                    'successflag' => false,
                ],
                'message' => '用户已投票',
            ])->setStatusCode(400);
        }

        if (!($option->vote->canVote)) {
            return response()->json([
                'status' => false,
                'data'=>[
                    'successflag' => false,
                ],
                'message' => '投票已关闭',
            ])->setStatusCode(400);
        }

        $user->options()->attach($option->id, ['vote_id' => $option->vote_id]);

        return response()->json([
                'status' => true,
                'data'=>[
                    'successflag' => true,
                ],
                'message' => '投票成功',
            ])->setStatusCode(200);
    }
}

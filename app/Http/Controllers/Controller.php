<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function authorize()
    {
        $owner=request()->user();

        if (!$owner->is_admin()) {
            return response()->json([
                'status' => false,
                'data'=>[
                    'successflag' => false
                ],
                'message' => '没有权限执行此操作',
            ])->setStatusCode(401);
        }
    }
}

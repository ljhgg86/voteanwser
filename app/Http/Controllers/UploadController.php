<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;
use App\Models\User;

class UploadController extends Controller
{
    public function upload(Request $request, ImageUploadHandler $uploader)
    {
        $user=$request->user();
        if ($request->file('file')) {
            $result = $uploader->save($request->file('file'), 'poll', $user->id, 724);
            if ($result) {
                return response()->json([
                    'status' => true,
                    'data'=> $result['path'],
                    'message' => '上传文件成功',
                ])->setStatusCode(200);
            }
        }

        return response()->json([
            'status' => false,
            'message' => '上传文件失败',
        ])->setStatusCode(401);

    }
}

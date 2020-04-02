<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inviterscore;

class InviterscoreController extends Controller
{
    //add by 0.618
    public function __construct() {
		$this->inviterscore = new Inviterscore();
	}
    /**
     * 获取分享数/邀请数排名
     *
     * @param int $flag
     * @return response
     */
    public function getScoresList(Request $request){
        $type = $request->input('type');
        $listcount = $request->input('listcount');
        $minid = $request->input('minid');
        $allInviterscores = null;
        switch($type){
            case 1:$allInviterscores = $this->inviterscore->getAllInviterscore($listcount, $minid); break;
            case 2:$allInviterscores = $this->inviterscore->getAllCheckscore($listcount, $minid); break;
            default:break;
        }
        if($allInviterscores){
            return response()->json([
                'status' => true,
                'data' => $allInviterscores,
                'message' => '成功',
            ])->setStatusCode(200);
        }
        else{
            return response()->json([
                'status' => false,
                'data' => '',
                'message' => '失败',
            ])->setStatusCode(400);
        }
    }

    /**
     * 获取用户排名信息
     *
     * @param int $userid
     * @param int $flag
     * @return response
     */
    public function getUserScore($userid,$type){
        $inviterscores = null;
        switch($type){
            case 1:$inviterscores = $this->inviterscore->getInviterRank($userid); break;
            case 2:$inviterscores = $this->inviterscore->getCheckRank($userid); break;
            default:break;
        }
        if($inviterscores){
            return response()->json([
                'status' => true,
                'data' => $inviterscores,
                'message' => '成功',
            ])->setStatusCode(200);
        }
        else{
            return response()->json([
                'status' => false,
                'data' => '',
                'message' => '失败',
            ])->setStatusCode(400);
        }
    }
}

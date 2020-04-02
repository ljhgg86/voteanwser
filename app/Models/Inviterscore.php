<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inviterscore extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'inviterscore';

    protected $fillable = ['inviter', 'inviterscore', 'update_time', 'checkscore', 'lastcheck_time'];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class, 'inviter', 'id');
    }

    /**
     * 获取分享新用户注册数排名列表
     *
     * @param int $listcount：获取条数
     * @param int $minid：上次获取最低排名的id
     * @return object
     */
    public function getAllInviterscore($listcount, $minid){
        $inviterscore = $this->find($minid);
        $count = 0;
        if($inviterscore){
            $count = $this->minidInviteRank($inviterscore);
        }
        return $this->where('inviterscore', '>', 0)
                    ->orderBy('inviterscore', 'DESC')
                    ->orderBy('update_time', 'ASC')
                    ->orderBy('id', 'ASC')
                    ->skip($count)
                    ->take($listcount)
                    ->select('id', 'inviter', 'inviterscore as score', 'update_time as time')
                    ->with('user:id,nickname,user_avatar')
                    ->get();
    }

    /**
     * 获取分享点击数排名表
     *
     * @param int $listcount:获取条数
     * @param int $minid：上次获取最低排名的id
     * @return object
     */
    public function getAllCheckscore($listcount, $minid){
        $inviterscore = $this->find($minid);
        $count = 0;
        if($inviterscore){
            $count = $this->minidCheckRank($inviterscore);
        }
        return $this->where('checkscore', '>', 0)
                    ->orderBy('checkscore', 'DESC')
                    ->orderBy('lastcheck_time', 'ASC')
                    ->orderBy('id', 'ASC')
                    ->skip($count)
                    ->take($listcount)
                    ->select('id', 'inviter', 'checkscore as score', 'lastcheck_time as time')
                    ->with('user:id,nickname,user_avatar')
                    ->get();
    }

    /**
     * 用户分享新注册成功排名的位次
     *
     * @param Inviterscore $inviterscore
     * @return int
     */
    public function minidInviteRank($inviterscore){
        return $this->where('iniviterscore', '>', $inviterscore->inviterscore)
                    ->orWhere(function($query) use ($inviterscore){
                        $query->where('inviterscore',$inviterscore->inviterscore)
                            ->where('update_time', '<', $inviterscore->update_time);
                    })
                    ->orWhere(function($query) use ($inviterscore){
                        $query->where('inviterscore',$inviterscore->inviterscore)
                            ->where('update_time',$inviterscore->update_time)
                            ->where('id', '<', $inviterscore->id);
                    })
                    ->count() + 1;
    }

    /**
     * 用户分享点击数排名的位次
     *
     * @param Inviter $inviterscore
     * @return int
     */
    public function minidCheckRank($inviterscore){
        return $this->where('checkscore', '>', $inviterscore->checkscore)
                    ->orWhere(function($query) use ($inviterscore){
                        $query->where('checkscore',$inviterscore->checkscore)
                            ->where('lastcheck_time', '<', $inviterscore->lastcheck_time);
                    })
                    ->orWhere(function($query) use ($inviterscore){
                        $query->where('checkscore',$inviterscore->checkscore)
                            ->where('lastcheck_time',$inviterscore->lastcheck_time)
                            ->where('id', '<', $inviterscore->id);
                    })
                    ->count() + 1;
    }

    /**
     * 获取用户邀请新用户注册数排名
     *
     * @param int $userid
     * @return json
     */
    public function getInviterRank($userid){
        $inviterscore = $this->getInviterscore($userid);
        if(!count($inviterscore)){
            return false;
        }
        $ranknum = $this->where('inviterscore', '>', $inviterscore[0]->inviterscore)
                        ->orWhere(function($query) use($inviterscore) {
                            $query->where('inviterscore',$inviterscore[0]->inviterscore)
                                    ->where('update_time', '<', $inviterscore[0]->update_time);
                        })
                        ->orWhere(function($query) use($inviterscore){
                            $query->where('inviterscore',$inviterscore[0]->inviterscore)
                                    ->where('update_time', $inviterscore[0]->update_time)
                                    ->where('id', '<', $inviterscore[0]->id);
                        })
                        ->count();
        return [
            'inviter'=>$inviterscore[0]->inviter,
            'score'=>$inviterscore[0]->inviterscore,
            'ranknum'=>$ranknum+1
        ];
    }

    /**
     * 获取用户邀请点击数排名
     *
     * @param int $userid
     * @return json
     */
    public function getCheckRank($userid){
        $inviterscore = $this->getInviterscore($userid);
        if(!count($inviterscore)){
            return false;
        }
        $ranknum = $this->where('checkscore', '>', $inviterscore[0]->checkscore)
                        ->orWhere(function($query) use($inviterscore) {
                            $query->where('checkscore',$inviterscore[0]->checkscore)
                                    ->where('lastcheck_time', '<', $inviterscore[0]->lastcheck_time);
                        })
                        ->orWhere(function($query) use($inviterscore){
                            $query->where('checkscore',$inviterscore[0]->checkscore)
                                    ->where('lastcheck_time', $inviterscore[0]->lastcheck_time)
                                    ->where('id', '<', $inviterscore[0]->id);
                        })
                        ->count();
        return [
            'inviter'=>$inviterscore[0]->inviter,
            'score'=>$inviterscore[0]->checkscore,
            'ranknum'=>$ranknum+1
        ];
    }

    /**
     * 获取用户在排名表的信息
     *
     * @param int $userid
     * @return Inviterscore
     */
    public function getInviterscore($userid){
        return $this->where('inviter',$userid)
                    ->get();
    }


}

<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Option;
use App\Models\Answer;
use App\Models\UserVote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\OptionRequest;
Use App\Http\Resources\OptionResource;
use App\Events\InputAnswerEvent;
use App\Events\RegenerateRankinglistEvent;

class OptionsController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Vote $vote)
	{
        $options = Option::where('vote_id', $vote->id)
            ->orderBy('id', 'asc')
            ->with('vote', 'vote.voteInfos')
            ->get();

        if ($options->count()==0){
            return response()->json([
                'status' => false,
                'data'=>[],
                'message' => '访问对象不存在',
            ])->setStatusCode(400);
        }

        return response()->json([
            'status' => true,
            'data'=> OptionResource::collection($options),
            'message' => '成功',
        ])->setStatusCode(200);
	}

    public function options(OptionRequest $request, Vote $vote)
    {
        $this->authorize();

        $options = Option::where('vote_id', $vote->id)
            ->orderBy('id', 'asc')
            ->paginate($request->per_page);

        $count=Option::where('vote_id', $vote->id)->count();

        if ($count==0){
            return response()->json([
                'status' => false,
                'data'=> [],
                'message' => '访问对象不存在',
            ])->setStatusCode(400);
        }

        return response()->json([
            'status' => true,
            'data'=> OptionResource::collection($options),
            'totalpage' => floor(($count+$request->per_page-1)/$request->per_page),
            'message' => '成功',
        ])->setStatusCode(200);
    }

    public function show(Vote $vote, Option $option)
    {
        $option = Option::where('id', $option->id)
            ->with('vote', 'vote.voteInfos')
            ->first();

        return response()->json([
           'status' => true,
           'data'=> new OptionResource($option),
           'message' => '成功',
        ])->setStatusCode(200);
    }

    public function store(OptionRequest $request, Vote $vote)
    {
        $this->authorize();

        $option = Option::make($request->all());

        $vote->options()->save($option);

        return response()->json([
            'status' => true,
            'data'=> new OptionResource($option),
            'message' => '成功',
        ])->setStatusCode(200);
    }

	public function edit(Vote $vote, Option $option)
	{
        $this->authorize();

        return response()->json([
            'status' => true,
            'data'=> new OptionResource($option),
            'message' => '成功',
        ])->setStatusCode(200);
	}

	public function update(OptionRequest $request, Vote $vote, Option $option)
	{
		$this->authorize();

        $option->update($request->all());

        return response()->json([
            'status' => true,
            'data'=> new OptionResource($option),
            'message' => '成功',
        ])->setStatusCode(200);
	}

	public function destroy(Vote $vote, Option $option)
	{
		$this->authorize();

        if ($option->userVotes()->isNotEmpty()) {
            return response()->json([
                'status' => false,
                'message' => '用户投票记录已存在无法删除',
            ])->setStatusCode(400);
        }

        //先删除答案
        $answer=Answer::where('option_id', $option->id)->first();
        $answer->delete();

		$option->delete();

		return response()->json([
            'status' => true,
            'data'=>[],
            'message' => '删除成功',
        ])->setStatusCode(200);
	}

    public function batSave(OptionRequest $request, Vote $vote)
    {
        // 数据格式option:[{"id": 0, "option":"a", "thumbnail": "a.jpg", "vote_count": 99, "description": "description", "correctflag": 1, statusflag": 0}]
        // option{
        // id:1,
        // vote_id:10
        // option:'asdf',
        // thumbnail:'http://abc.com/a.jpg',
        // vote_count:456,
        // description:'haha',
        // correctflag:0               (0错误，1是正确)
        // statusflag:0               ( 0是新增，1是update，2是del)

        $this->authorize();

        $options=collect(json_decode($request->option));

        if ($options->isEmpty())
        {
           return response()->json([
                'status' => false,
                'data'=>[
                    'successflag' => false,
                ],
                'message' => '数据格式错误，请重新输入！',
            ])->setStatusCode(400);
        }

        $vote->reflag=false;

        $options->each(function($option) use ($vote) {
            if ($option->statusflag==2) {
                //delete
                if ($option->id) {
                     //先删除答案
                    $answer=Answer::where('option_id', $option->id)->first();
                    //处理回滚，投票人员回滚，
                    if ($answer) {
                        $answer->delete();
                       $vote->reflag=true;
                    }

                    //uservote的删除
                    UserVote::where('option_id', $option->id)->delete();
                    //option的删除
                    option::where('id', $option->id)->delete();
                    //vote vote_count
                    if ($vote->options->isEmpty()) {
                        $vote->vote_count = 0;
                        $vote->save();
                    }
                }
            } else if ($option->statusflag==1) {
                //update
                if ($option->id) {
                    if (($option->option) || ($option->thumbnail)) {
                        $op=option::find($option->id);
                        $op->option=$option->option;
                        $op->thumbnail=$option->thumbnail;
                        $op->vote_count=$option->vote_count;
                        $op->description=$option->description;
                        $op->save();
                        $answer=Answer::where('option_id', $option->id)->first();
                        $ids=[$op->id];
                        if (!$answer) {
                            if ($option->correctflag) {
                                Event(new InputAnswerEvent($vote, $ids));
                            }
                        } else {
                            if (!$option->correctflag) {
                                Event(new InputAnswerEvent($vote, $ids));
                                $vote->reflag = true;
                            }
                        }
                    }
                }
            } else if ($option->statusflag==0) {
                //insert
                if (($option->option) || ($option->thumbnail)) {
                    $op=Option::create(['vote_id'=>$vote->id,'option'=>$option->option, 'thumbnail'=> $option->thumbnail, 'vote_count'=> $option->vote_count, 'description'=> $option->description ]);
                    $ids=[$op->id];
                    if ($option->correctflag) {
                        Event(new InputAnswerEvent($vote, $ids));
                    }
                }
            }
        });

        //生成出现计算排名事件
        if ($vote->reflag) {
            Event(new RegenerateRankinglistEvent($vote->poll_id));
        }

        return response()->json([
                'status' => true,
                'data'=>[
                    'successflag' => true,
                ],
                'message' => '批量数据添加成功！'
        ])->setStatusCode(200);
    }

}
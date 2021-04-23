<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\PollRequest;
use App\Http\Resources\PollResource;
use App\Models\Poll;
use App\Models\User;
use App\Models\Inviterscore;
use Illuminate\Http\Request;
Use Carbon\Carbon;

class PollsController extends Controller {
	public function __construct() {
		//$this->middleware('auth', ['except' => ['index', 'show']]);
	}

	public function index(Request $request) {
		$flagTime = strtotime("2021-05-13");
		$currentTime = strtotime(date('Y-m-d'));
		$diffDays = ($flagTime - $currentTime)/(24*3600);
		
		if($diffDays > 0){
			$polls = Poll::where('id', '<', $request->min_id)
			->where('delflag', false)
			->where('verifyflag', true)
			->orderBy('id', 'desc')
			->skip($diffDays)
			->take($request->listcount)
			->get();
		 //->with('votes','votes.options')->get();
		}
		else{
			$polls = Poll::where('id', '<', $request->min_id)
			->where('delflag', false)
			->where('verifyflag', true)
			->orderBy('id', 'desc')
			->take($request->listcount)
			->get();
		//->with('votes','votes.options')->get();
		}

		if ($polls->count() == 0) {
			return response()->json([
				'status' => false,
				'data' => [],
				'message' => '访问对象不存在',
			])->setStatusCode(400);
		}

		// $polls->each(function($poll){
		//     if (!$poll->show_votecount) {
		//         $poll->vote_count=0;
		//         return $poll;
		//     }
		// });

		return response()->json([
			'status' => true,
			'data' => PollResource::collection($polls),
			'beginDate' => '2021/02/01 00:00:01',
			'message' => '成功',
		])->setStatusCode(200);
	}

	public function polls(Request $request) {
		$this->authorize();

		// 创建一个查询构造器
		$builder = Poll::where('delflag', false);
		// 判断是否有提交 search 参数，如果有就赋值给 $search 变量
		// search 参数用来模糊搜索商品
		if ($search = $request->input('search', '')) {
			$like = '%' . $search . '%';
			// 模糊搜索商品标题、商品详情、SKU 标题、SKU描述
			$builder->where(function ($query) use ($like) {
				$query->where('title', 'like', $like)
					->orWhere('description', 'like', $like)
					->orWhereHas('category', function ($query) use ($like) {
						$query->where('title', 'like', $like)
							->orWhere('description', 'like', $like);
					});
			});
		}

		$per_page = $request->input('per_page', 10);
		$count = $builder->count();

		$polls = $builder->orderBy('id', 'desc')
			->paginate($per_page);

		if ($polls->isEmpty()) {
			return response()->json([
				'status' => false,
				'data' => [],
				'message' => '访问对象不存在',
			])->setStatusCode(400);
		}

		return response()->json([
			'status' => true,
			'data' => PollResource::collection($polls),
			'count' => $count,
			'totalpage' => floor(($count + $per_page - 1) / $per_page),
			'message' => '成功',
		])->setStatusCode(200);
	}

	public function show(Poll $poll, $userid=0) {
		$poll = Poll::where('id', $poll->id)
			->with('votes', 'votes.options', 'votes.voteInfos')->first();

		if ($poll->delflag) {
			return response()->json([
				'status' => false,
				'data' => [],
				'message' => '访问对象不存在',
			])->setStatusCode(400);
		}

		//start add by 0.618
		// if($userid){
		// 	Inviterscore::updateOrCreate(
		// 		['inviter' => $userid],
		// 		['lastcheck_time' => Carbon::now()]
		// 	);
		// 	Inviterscore::where('inviter', $userid)
		// 				->increment('checkscore');
		// }
		
		//end
		
		return response()->json([
			'status' => true,
			'data' => new PollResource($poll),
			'message' => '成功',
		])->setStatusCode(200);
	}

	public function store(PollRequest $request) {

		$this->authorize();

		$poll = Poll::make($request->all());

		$owner = $request->user();

		$owner->create_polls()->save($poll);

		$poll = Poll::where('id', $poll->id)->with('owner')->first();

		return response()->json([
			'status' => true,
			'data' => $poll,
			'message' => '成功',
		])->setStatusCode(200);

	}

	public function edit(Poll $poll) {
		$this->authorize();

		if ($poll->delflag) {
			return response()->json([
				'status' => false,
				'data' => [],
				'message' => '访问对象不存在',
			])->setStatusCode(400);
		}

		return response()->json([
			'status' => true,
			'data' => new PollResource($poll),
			'message' => '成功',
		])->setStatusCode(200);
	}

	public function update(PollRequest $request, Poll $poll) {
		$this->authorize();

		$poll->update($request->all());

		return response()->json([
			'status' => true,
			'data' => $poll,
			'message' => '成功',
		])->setStatusCode(200);
	}

	public function destroy(Poll $poll) {
		$this->authorize();

		$poll->delflag = true;
		$poll->save();

		return response()->json([
			'status' => true,
			'data' => [],
			'message' => '删除成功',
		])->setStatusCode(200);
	}

	public function upload(PollRequest $request, ImageUploadHandler $uploader, Poll $poll) {
		//dd($request->thumbnail);
		if ($request->file('file')) {
			$result = $uploader->save($request->file('file'), 'poll', $poll->id, 724);
			if ($result) {
				$poll->thumbnail = $result['path'];
				$poll->save();
			}
		} else {
			return response()->json([
				'status' => false,
				'message' => '上传文件失败',
			])->setStatusCode(401);
		}

		return response()->json([
			'status' => true,
			'data' => $poll->thumbnail,
			'message' => '上传文件成功',
		])->setStatusCode(200);
	}

}
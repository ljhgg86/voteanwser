<?php

namespace App\Http\Controllers;

use App\Events\InputAnswerEvent;
use App\Events\UserVotedEvent;
use App\Events\UserPollEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\VoteRequest;
use App\Http\Resources\VoteResource;
use App\Models\Answer;
use App\Models\Option;
use App\Models\Poll;
use App\Models\UserVote;
use App\Models\Vote;
use Carbon\Carbon;

class VotesController extends Controller {
	public function __construct() {
		//$this->middleware('auth', ['except' => ['index', 'show']]);
		$this->vote = new Vote();
	}

	public function index(Poll $poll) {
		$votes = Vote::where('poll_id', $poll->id)
			->where('delflag', false)
			->orderBy('id', 'asc')
			->with('poll', 'options', 'voteInfos')
			->get();

		if ($votes->count() == 0) {
			return response()->json([
				'status' => false,
				'data' => [],
				'message' => '访问对象不存在',
			])->setStatusCode(400);
		}

		return response()->json([
			'status' => true,
			'data' => VoteResource::collection($votes),
			'message' => '成功',
		])->setStatusCode(200);
	}

	public function votes(VoteRequest $request, Poll $poll) {
		$this->authorize();
		// 创建一个查询构造器
		$builder = Vote::where('poll_id', $poll->id)->where('delflag', false);
		// 判断是否有提交 search 参数，如果有就赋值给 $search 变量
		// search 参数用来模糊搜索商品
		if ($search = $request->input('search', '')) {
			$like = '%' . $search . '%';
			// 模糊搜索商品标题、商品详情、SKU 标题、SKU描述
			$builder->where(function ($query) use ($like) {
				$query->where('title', 'like', $like)
					->orWhere('description', 'like', $like);
			});
		}

		$per_page = $request->input('per_page', 10);
		$count = $builder->count();

		$votes = $builder->orderBy('id', 'desc')
			->paginate($per_page);

		if ($votes->isEmpty()) {
			return response()->json([
				'status' => false,
				'data' => [],
				'message' => '访问对象不存在',
			])->setStatusCode(400);
		}

		return response()->json([
			'status' => true,
			'data' => VoteResource::collection($votes),
			'totalpage' => floor(($count + $per_page - 1) / $per_page),
			'message' => '成功',
		])->setStatusCode(200);
	}

	public function show(Poll $poll, Vote $vote) {
		$vote = Vote::where('id', $vote->id)
			->with('poll', 'options', 'voteInfos')
			->first();

		if ($vote->delflag) {
			return response()->json([
				'status' => false,
				'data' => [],
				'message' => '访问对象不存在',
			])->setStatusCode(400);
		}

		return response()->json([
			'status' => true,
			'data' => new VoteResource($vote),
			'message' => '成功',
		])->setStatusCode(200);
	}

	public function currentVote(Poll $poll) {
		$currentTime = Carbon::now()->toDateTimeString();
		//$tomorrow = Carbon::tomorrow()->toDateString() . ' ' . env('END_TIME');

		$votes = Vote::where('poll_id', $poll->id)->where('delflag', false)
			->where('start_at', '<=', $currentTime)
			->where('end_at', '>=', $currentTime)
			->orderBy('id', 'asc')
			->with('poll', 'options', 'voteInfos')
			->get();

		if ($votes->isEmpty()) {
			return response()->json([
				'status' => false,
				'data' => [],
				'message' => '访问对象不存在',
			])->setStatusCode(400);
		}

		return response()->json([
			'status' => true,
			'data' => VoteResource::collection($votes),
			'message' => '成功',
		])->setStatusCode(200);
	}

	public function pastVote(VoteRequest $request, Poll $poll) {
		$today = Carbon::now()->toDateString() . ' ' . env('START_TIME');

		$listcount = 10;
		$min_id = 10000000000;

		if ($request->has('listcount')) {
			$listcount = $request->listcount;
		}

		if ($request->has('min_id')) {
			$min_id = $request->min_id;
		}

		$votes = Vote::where('poll_id', $poll->id)->where('delflag', false)
			->where('id', '<', $min_id)
			->where('end_at', '<=', $today)
			->orderBy('id', 'desc')
			->with('poll', 'options', 'voteInfos')
			->take($listcount)
			->get();

		if ($votes->count() == 0) {
			return response()->json([
				'status' => false,
				'data' => [],
				'message' => '访问对象不存在',
			])->setStatusCode(400);
		}

		return response()->json([
			'status' => true,
			'data' => VoteResource::collection($votes),
			'message' => '成功',
		])->setStatusCode(200);
	}

	public function store(VoteRequest $request, Poll $poll) {
		$this->authorize();

		$vote = Vote::make($request->all());

		$poll->votes()->save($vote);

		return response()->json([
			'status' => true,
			'data' => new VoteResource($vote),
			'message' => '成功',
		])->setStatusCode(200);
	}

	public function edit(Poll $poll, Vote $vote) {
		$this->authorize();

		if ($vote->delflag) {
			return response()->json([
				'status' => false,
				'data' => [],
				'message' => '访问对象不存在',
			])->setStatusCode(400);
		}

		return response()->json([
			'status' => true,
			'data' => new VoteResource($vote),
			'message' => '成功',
		])->setStatusCode(200);
	}

	public function update(VoteRequest $request, Poll $poll, Vote $vote) {
		$this->authorize();

		$vote->update($request->all());

		return response()->json([
			'status' => true,
			'data' => new VoteResource($vote),
			'message' => '成功',
		])->setStatusCode(200);
	}

	public function destroy(Poll $poll, Vote $vote) {
		$this->authorize();
		$vote->delflag = true;
		$vote->save();

		return response()->json([
			'status' => true,
			'data' => [],
			'message' => '删除成功',
		])->setStatusCode(200);
	}

	public function voted(VoteRequest $request, Vote $vote) {

		// 投票格式 [{"option_id":1,"selected":false},{"option_id":2,"selected":true},{"option_id":3,"selected":false}]

		$user = $request->user();

		if (!$user) {
			return response()->json([
				'status' => false,
				'data' => [
					'successflag' => false,
				],
				'message' => '用户未登录',
			])->setStatusCode(400);
		}

		if (!$request->has('option')) {
			return response()->json([
				'status' => false,
				'data' => [
					'successflag' => false,
				],
				'message' => '用户选择了错误选项',
			])->setStatusCode(400);
		}

		//查询用户是否已经投票
		if ($user->options->pluck('vote_id')->contains($vote->id)) {
			return response()->json([
				'status' => false,
				'data' => [
					'successflag' => false,
				],
				'message' => '用户已投票',
			])->setStatusCode(400);
		}

		if (!($vote->canVote)) {
			return response()->json([
				'status' => false,
				'data' => [
					'successflag' => false,
				],
				'message' => '投票已关闭',
			])->setStatusCode(400);
		}

		$options = collect(json_decode($request->option));

		if ($options->isEmpty()) {
			return response()->json([
				'status' => false,
				'data' => [
					'successflag' => false,
				],
				'message' => '投票数据错误，请重新输入！',
			])->setStatusCode(400);
		}

		$ids = $options->filter(function ($option) {
			return $option->selected;
		})->map(function ($option) {
			return $option->option_id;
		})->toArray();

		if (($vote->option_type == 1) && (count($ids) > 1)) {
			return response()->json([
				'status' => false,
				'data' => [
					'successflag' => false,
				],
				'message' => '此投票为单选，不能选择多个答案',
			])->setStatusCode(400);
		}

		$eventFlag = false;

		$poll = Poll::find($vote->poll_id);

		$vids = $poll->votes->pluck('id');
		$uv = UserVote::where('user_id', $user->id)
			->whereIn('vote_id', $vids)
			->get();

		foreach ($ids as $id) {

			$correct = false;

			$answer = Answer::where('option_id', $id)->where('vote_id', $vote->id)->first();

			if ($answer) {
				$correct = true;
				$eventFlag = true;
			}

			$user->options()->attach($id, ['vote_id' => $vote->id, 'correct' => $correct]);
			$option = Option::find($id);
			$option->increment('vote_count');
		}

		//添加用户投票事件 调用用户投票的排名处理方法
		if ($eventFlag) {
			Event(new UserVotedEvent($vote, $user, $ids));
		}

		$vote->increment('vote_count');

		if ($uv->isEmpty()) {
			$poll->increment('vote_count');
		}

		return response()->json([
			'status' => true,
			'data' => [
				'successflag' => true,
			],
			'message' => '投票成功',
		])->setStatusCode(200);
	}

	public function answer(VoteRequest $request, Vote $vote) {
		$this->authorize();

		// 查询用户是否已经投票
		if (Answer::where('vote_id', $vote->id)->get()->isNotEmpty()) {
			return response()->json([
				'status' => false,
				'data' => [
					'successflag' => false,
				],
				'message' => '此投票的答案已存在！',
			])->setStatusCode(400);
		}

		$options = collect(json_decode($request->option));

		if ($options->isEmpty()) {
			return response()->json([
				'status' => false,
				'data' => [
					'successflag' => false,
				],
				'message' => '投票数据错误，请重新输入！',
			])->setStatusCode(400);
		}

		$ids = $options->filter(function ($option) {
			return $option->selected;
		})->map(function ($option) {
			return $option->option_id;
		})->toArray();

		if (($vote->option_type == 1) && (count($ids) > 1)) {
			return response()->json([
				'status' => false,
				'data' => [
					'successflag' => false,
				],
				'message' => '此投票为单选，不能选择多个答案',
			])->setStatusCode(400);
		}

		//添加输入答案事件 调用用户投票的排名处理方法
		Event(new InputAnswerEvent($vote, $ids));

		return response()->json([
			'status' => true,
			'data' => [
				'successflag' => true,
			],
			'message' => '答案输入成功',
		])->setStatusCode(200);
	}

	public function voteds(VoteRequest $request, Poll $poll){
		$user = $request->user();

		if (!$user) {
			return response()->json([
				'status' => false,
				'data' => [
					'successflag' => false,
				],
				'message' => '用户未登录',
			])->setStatusCode(400);
		}

		if (!$request->has('choices')) {
			return response()->json([
				'status' => false,
				'data' => [
					'successflag' => false,
				],
				'message' => '用户选择了错误选项',
			])->setStatusCode(400);
		}
		$choices = $request->get('choices');
		$vote0 = Vote::find($choices[0]['vote_id']);
		dump($vote0->canView);
		if (!($vote0->canView)) {
			return response()->json([
				'status' => false,
				'data' => [
					'successflag' => false,
				],
				'message' => '活动已关闭',
			])->setStatusCode(400);
		}
		$correctNum = $this->vote->handleVotes($choices);
		if($correctNum){
			Event(new UserPollEvent($poll, $user, $correctNum));
		}
		$poll->increment('vote_count');
		$voteCounts = count($poll->load('votes')->votes);
		return response()->json([
			'status' => true,
			'data' => [
				'correctNum' => $correctNum,
				'failNum' => $voteCounts-$correctNum,
			],
			'message' => '提交成功',
		])->setStatusCode(200);
	}
}
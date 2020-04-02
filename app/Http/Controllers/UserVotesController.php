<?php

namespace App\Http\Controllers;

use App\Models\UserVote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserVoteRequest;

class UserVotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index()
	{
		$user_votes = UserVote::paginate();
		return view('user_votes.index', compact('user_votes'));
	}

    public function show(UserVote $user_vote)
    {
        return view('user_votes.show', compact('user_vote'));
    }

	public function create(UserVote $user_vote)
	{
		return view('user_votes.create_and_edit', compact('user_vote'));
	}

	public function store(UserVoteRequest $request)
	{
		$user_vote = UserVote::create($request->all());
		return redirect()->route('user_votes.show', $user_vote->id)->with('message', 'Created successfully.');
	}

	public function edit(UserVote $user_vote)
	{
        $this->authorize('update', $user_vote);
		return view('user_votes.create_and_edit', compact('user_vote'));
	}

	public function update(UserVoteRequest $request, UserVote $user_vote)
	{
		$this->authorize('update', $user_vote);
		$user_vote->update($request->all());

		return redirect()->route('user_votes.show', $user_vote->id)->with('message', 'Updated successfully.');
	}

	public function destroy(UserVote $user_vote)
	{
		$this->authorize('destroy', $user_vote);
		$user_vote->delete();

		return redirect()->route('user_votes.index')->with('message', 'Deleted successfully.');
	}
}
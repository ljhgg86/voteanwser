<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerRequest;

class AnswersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index()
	{
		$answers = Answer::paginate();
		return view('answers.index', compact('answers'));
	}

    public function show(Answer $answer)
    {
        return view('answers.show', compact('answer'));
    }

	public function create(Answer $answer)
	{
		return view('answers.create_and_edit', compact('answer'));
	}

	public function store(AnswerRequest $request)
	{
		$answer = Answer::create($request->all());
		return redirect()->route('answers.show', $answer->id)->with('message', 'Created successfully.');
	}

	public function edit(Answer $answer)
	{
        $this->authorize('update', $answer);
		return view('answers.create_and_edit', compact('answer'));
	}

	public function update(AnswerRequest $request, Answer $answer)
	{
		$this->authorize('update', $answer);
		$answer->update($request->all());

		return redirect()->route('answers.show', $answer->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Answer $answer)
	{
		$this->authorize('destroy', $answer);
		$answer->delete();

		return redirect()->route('answers.index')->with('message', 'Deleted successfully.');
	}
}
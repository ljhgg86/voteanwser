<?php

namespace App\Models;
use Carbon\Carbon;

class Vote extends Model
{
    protected $fillable = ['title', 'thumbnail', 'start_at', 'end_at', 'view_end_at', 'option_count', 'option_type', 'vote_type', 'vote_count', 'show_votecount', 'description'];

    protected $casts = [
        'show_votecount' => 'boolean',
        'delflag' => 'boolean',
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class, 'poll_id');
    }

    public function options()
    {
        return $this->hasMany(Option::class, 'vote_id');
    }

    public function voteInfos()
    {
        return $this->hasMany(VoteInfo::class, 'vote_id');
    }

    public function getVoteCountAttribute($value)
    {
        $user=request()->user();

        $is_admin=false;

        if ($user) {
            $is_admin = $user->is_admin();
        }

        if ($is_admin || $this->show_votecount )
        {
            return $value;
        }

        return 0;

    }

    public function getCanVoteAttribute()
    {
        if (($this->start_at<=Carbon::now()) && ($this->end_at>=Carbon::now())){
            return true;
        }

        return false;
    }

    public function answers()
    {
        return $this->belongsToMany(Option::class, 'answers', 'vote_id', 'option_id')->withTimestamps();
    }

    public function getCanViewAttribute(){
        return $this->view_end_at >= Carbon::now();
    }

    public function handleVotes($choices){
        $user=request()->user();
        $correctNum = 0;
		foreach($choices as $choice){
			$vote_id = $choice['vote_id'];
            $vote = Vote::find($vote_id);
			$options = collect($choice['options']);
			if ($options->isEmpty()) {
				continue;
			}
			$ids = $options->filter(function ($option) {
				return $option['selected'];
			})->map(function ($option) {
				return $option['option_id'];
            })->toArray();
			foreach ($ids as $id) {
				$correct = false;
				$answer = Answer::where('option_id', $id)->where('vote_id', $vote_id)->first();
				if ($answer) {
					$correct = true;
				}
				$user->options()->attach($id, ['vote_id' => $vote->id, 'correct' => $correct]);
				$option = Option::find($id);
				$option->increment('vote_count');
			}
			$vote->increment('vote_count');
            $answer_ids = Answer::where('vote_id', $vote_id)->get()->pluck('option_id');
			if($answer_ids->diff(collect($ids))->isEmpty() && collect($ids)->diff($answer_ids)->isEmpty()){
				++$correctNum;
			}
        }
        return $correctNum;
    }

}

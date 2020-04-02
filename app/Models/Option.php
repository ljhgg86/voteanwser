<?php

namespace App\Models;

class Option extends Model
{
    protected $fillable = ['vote_id', 'option', 'thumbnail', 'vote_count', 'description'];

    public function vote()
    {
        return $this->belongsTo(Vote::class, 'vote_id');
    }

    public function getVoteCountAttribute($value)
    {

        $user=request()->user();

        $is_admin=false;

        if ($user) {
            $is_admin = $user->is_admin();
        }

        if ($is_admin || $this->vote->show_votecount )
        {
            return $value;
        }

        return 0;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_votes', 'option_id', 'user_id');
    }

    public function questions()
    {
        return $this->belongsToMany(vote::class, 'answers', 'option_id', 'vote_id');
    }

    public function userVotes()
    {
        return $this->hasMany(UserVote::class, 'option_id');
    }

    public function isAnswer()
    {
        $answer=Answer::where('option_id', $this->id)->first();
        if ($answer) {
            return 1;
        }
        return 99;
    }

}

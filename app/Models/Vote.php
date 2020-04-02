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

}

<?php

namespace App\Models;

class Poll extends Model {
	protected $fillable = ['title', 'thumbnail', 'description', 'rules', 'category_id', 'show_votecount', 'vote_count', 'endflag', 'verifyflag'];

	protected $casts = [
		'show_votecount' => 'boolean',
		'verifyflag' => 'boolean',
		'endflag' => 'boolean',
		'delflag' => 'boolean',
	];

	public function owner() {
		return $this->belongsTo(User::class, 'createuser_id');
	}

	public function auditor() {
		return $this->belongsTo(User::class, 'verifyuser_id');
	}

	public function votes() {
		return $this->hasMany(Vote::class, 'poll_id');
	}

	public function getVoteCountAttribute($value) {
		$user = request()->user();

		$is_admin = false;

		if ($user) {
			$is_admin = $user->is_admin();
		}

		if ($is_admin || $this->show_votecount) {
			return $value;
		}

		return 0;
	}

	public function category() {
		return $this->belongsTo(Category::class, 'category_id');
	}

	public function rankinglists() {
		return $this->hasMany(Rankinglist::class, 'poll_id');
	}
}
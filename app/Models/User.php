<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'nickname', 'realname', 'phone', 'user_avatar', 'inviter',//add inviter by 0.618
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function findForPassport($username)
    {
        filter_var($username, FILTER_VALIDATE_EMAIL) ?
          $credentials['email'] = $username :
          $credentials['name'] = $username;

        return self::where($credentials)->first();
    }

    public function create_polls()
    {
        return $this->hasMany(Poll::class, 'createuser_id');
    }

    public function verify_polls()
    {
        return $this->hasMany(Poll::class, 'verifyuser_id');
    }

    public function is_admin()
    {
        return $this->role_id==0;
    }

    public function options()
    {
        return $this->belongsToMany(Option::class, 'user_votes', 'user_id', 'option_id')->withTimestamps()->withPivot('correct');
    }

    public function userVotes() {
        return $this->hasMany(UserVote::class);
    }

    public function rankinglists()
    {
        $this->hasMany(Rankinglist::class, 'user_id');
    }

    public function rewardLogs()
    {
        return $this->hasMany(RewardLog::class, 'user_id');
    }

    public function rewardRecords()
    {
        return $this->hasMany(RewardRecord::class, 'user_id');
    }

    //add by 0.618
    public function inviterscore(){
        return $this->hasOne(Inviterscore::class, 'inviter', 'id');
    }

}

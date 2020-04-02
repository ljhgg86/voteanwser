<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsRecord extends Model
{
    protected $fillable = [
        'name', 'verification_code', 'expired_at'
    ];
}

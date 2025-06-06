<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $guarded = ['id'];

    //

    public function influencer()
    {
        return $this->belongsTo(User::class);
    }

    public function studio()
    {
        return $this->belongsTo(User::class);
    }

    public function request()
    {
        return $this->belongsTo(Request::class);
    }



}

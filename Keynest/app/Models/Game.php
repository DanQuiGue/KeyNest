<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $guarded = [];

    //

    public function company()
    {
        return $this->belongsTo(User::class)->where('type', 'company');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }


    public function keys()
    {
        return $this->hasMany(Key::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $guarded = ['id'];

    //

    public function game()
    {
        return $this->belongsTo(Game::class)->whereHas('keys', function ($query) {
            $query->where('used', false);
        });
    }

    public function key()
    {
        return $this->belongsTo(Key::class);
    }

    public function influencer()
    {
        return $this->belongsTo(User::class)->where('type','user');
    }

}

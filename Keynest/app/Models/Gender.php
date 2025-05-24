<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $guarded = ['id'];

    //

    public function games()
    {
        return $this->hasMany(Game::class);
    }

}
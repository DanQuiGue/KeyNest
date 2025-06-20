<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $guarded=[];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions():BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }
}

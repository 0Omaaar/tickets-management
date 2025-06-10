<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function modules(){
        return $this->hasMany(Module::class);
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }
}

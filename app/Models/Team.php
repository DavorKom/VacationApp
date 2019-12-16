<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Team extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function projectManager()
    {
        return $this->belongsTo(User::class);
    }

    public function teamLead()
    {
        return $this->belongsTo(User::class);
    }
}

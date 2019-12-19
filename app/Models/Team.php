<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\VacationRequest;

class Team extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function vacationRequests()
    {
        return $this->hasMany(VacationRequest::class);
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

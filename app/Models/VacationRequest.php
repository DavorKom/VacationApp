<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Team;

class VacationRequest extends Model
{
    const PENDING = 'pending';
    const DENIED = 'denied';
    const APPROVED = 'approved';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}

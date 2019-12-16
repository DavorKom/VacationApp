<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    const ADMIN = 'admin';
    const APPROVER = 'project-manager-team-lead';
    const EMPLOYEE = 'employee';

    public function role()
    {
        return $this->hasMany(User::class);
    }
}

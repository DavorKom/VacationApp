<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Team;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the team.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Team  $team
     * @return mixed
     */
    public function view(User $user, Team $team)
    {
        $project_manager_id = data_get($team, 'project_manager_id');
        $team_lead_id = data_get($team, 'team_lead_id');

        if ($user->role->slug == Role::ADMIN) {
            return true;
        }

        if ($user->id == $project_manager_id || $user->id == $team_lead_id) {
            return true;
        }

        return false;
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        $project_manager_id = data_get($model->team, 'project_manager_id');
        $team_lead_id = data_get($model->team, 'team_lead_id');

        if ($user->role->slug == Role::ADMIN) {
            return true;
        }

        if ($user->id == $project_manager_id || $user->id == $team_lead_id) {
            return true;
        }

        if ($user->id == $model->id) {
            return true;
        }

        return false;
    }
}

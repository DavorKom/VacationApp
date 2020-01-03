<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VacationRequest;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class VacationRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the vacation request.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\VacationRequest  $vacationRequest
     * @return mixed
     */
    public function view(User $user, VacationRequest $vacationRequest)
    {
        $project_manager_id = data_get($vacationRequest->team, 'project_manager_id');
        $team_lead_id = data_get($vacationRequest->team, 'team_lead_id');

        if ($user->role->slug == Role::ADMIN) {
            return true;
        }

        if ($user->id == $project_manager_id || $user->id == $team_lead_id) {
            return true;
        }

        if ($user->id == $vacationRequest->user_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the vacation request.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\VacationRequest  $vacationRequest
     * @return mixed
     */
    public function update(User $user, VacationRequest $vacationRequest)
    {
        if ($user->role->slug == Role::ADMIN) {
            return true;
        }

        if ($user->id == $vacationRequest->user_id) {
            return true;
        }

        return false;
    }
}

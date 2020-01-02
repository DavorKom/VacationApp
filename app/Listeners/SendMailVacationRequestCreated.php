<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Events\CreatedVacationRequest;
use App\Mail\VacationRequestCreatedMail;
use App\Models\User;
use App\Models\Role;
use App\Models\VacationRequest;

class SendMailVacationRequestCreated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CreatedVacationRequest $event)
    {
        $emails = [];

        $vacation_request = $event->vacation_request;
        $project_manager_id = data_get($event->user, 'team.projectManager.id');
        $team_lead_id = data_get($event->user, 'team.teamLead.id');
        $project_manager_email = data_get($event->user, 'team.projectManager.email');
        $team_lead_email = data_get($event->user, 'team.teamLead.email');

        if ($project_manager_email != null && $event->user->id != $project_manager_id) {
            array_push($emails, $project_manager_email);
        }

        if ($team_lead_email != null && $event->user->id != $team_lead_id) {
            array_push($emails, $team_lead_email);
        }

        if (($project_manager_email == null && $team_lead_email == null) || $vacation_request->status == VacationRequest::ADMIN) {
            $emails = [];

            $admins = User::whereHas('role', function($q) {
                $q->where('name', 'admin');
            })->get();

            foreach($admins as $admin) {
                array_push($emails, $admin->email);
            }
        }

        Mail::to($emails)->send(
            new VacationRequestCreatedMail($event)
        );
    }
}

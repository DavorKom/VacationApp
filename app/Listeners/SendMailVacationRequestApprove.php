<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Events\ApproveVacationRequest;
use App\Mail\VacationRequestApproveMail;

class SendMailVacationRequestApprove
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
    public function handle(ApproveVacationRequest $event)
    {
        $user_email = $event->vacation_request->user->email;

        Mail::to($user_email)->send(
            new VacationRequestApproveMail($event)
        );
    }
}

<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;
use App\Models\VacationData;

class CreateVacationData
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
    public function handle($event)
    {
        $contract_date = Carbon::createFromDate($event->user->contract_date);
        $now = Carbon::now();
        $months_worked = $now->diffInMonths($contract_date);

        $unused_vacation = 20;
        if ($months_worked < 6) {
            $unused_vacation = round(20 / 12 * $months_worked, 0, PHP_ROUND_HALF_EVEN);
        }

        $vacation_data = new VacationData;
        $vacation_data->user_id = $event->user->id;
        $vacation_data->unused_vacation = $unused_vacation;
        $vacation_data->used_vacation = 0;
        $vacation_data->paid_leave = 0;
        $vacation_data->save();
    }
}

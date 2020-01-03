<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VacationData;
use Illuminate\Support\Carbon;

class VacationDataYearly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacation-data:yearly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Yearly update for paid leave and vacation days.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $vacation_datas = VacationData::with('user')->get();

        foreach ($vacation_datas as $vacation_data) {
            $contract_date = Carbon::createFromDate($vacation_data->user->contract_date);
            $now = Carbon::now();
            $months_worked = $now->diffInMonths($contract_date);

            if ($months_worked > 6) {
                $vacation_data->unused_vacation += 20;
                $vacation_data->paid_leave = 0;
            }

            $vacation_data->used_vacation = 0;
            $vacation_data->save();
        }
    }
}

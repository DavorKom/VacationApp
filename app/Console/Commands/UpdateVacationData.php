<?php

namespace App\Console\Commands;

use App\Models\VacationData;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class UpdateVacationData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacation-data:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update number of unused vacation days for employees.';

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

            if($now->day == $contract_date->day && $months_worked < 6) {
                $last_month_unused_vacation = round(20 / 12 * $months_worked-1, 0, PHP_ROUND_HALF_EVEN);
                $this_month_unused_vacation = round(20 / 12 * $months_worked, 0, PHP_ROUND_HALF_EVEN);
                $vacation_data->unused_vacation = $vacation_data->unused_vacation + ($this_month_unused_vacation - $last_month_unused_vacation);
            }

            $vacation_data->save();
        }
    }
}

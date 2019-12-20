<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;



class VacationDataController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function test()
    {
        $user = User::find(1);

        $contract_date = Carbon::createFromDate($user->contract_date);
        $now = Carbon::now();
        $months_worked = $now->diffInMonths($contract_date);

        $unused_vacation = 20;
        if ($months_worked < 6) {
            $unused_vacation = round(20 / 12 * $months_worked, 0, PHP_ROUND_HALF_EVEN);
        }

        dd($unused_vacation);
    }
}

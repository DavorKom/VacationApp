<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\VacationData;
use App\Http\Resources\VacationDataResource;
use App\Http\Requests\VacationDataUpdateRequest;

class VacationDataController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(VacationData $vacation_data)
    {
        $vacation_data = VacationData::with('user.role', 'user.team')->find($vacation_data->id);
        $vacation_data = (new VacationDataResource($vacation_data))->all(request());

        return view('vacations.data.edit')->with([
            'vacation_data' => $vacation_data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VacationData $vacation_data)
    {
        $vacation_data->unused_vacation = $request->input('unused_vacation');
        $vacation_data->used_vacation = $request->input('used_vacation');
        $vacation_data->paid_leave = $request->input('paid_leave');
        $vacation_data->save();

        return redirect()->route('vacations.requests.user', $vacation_data->user_id);
    }
}

<?php

namespace App\Http\Controllers;

use App\Events\CreatedVacationRequest;
use App\Events\UpdatedVacationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\VacationRequestStoreRequest;
use App\Http\Requests\VacationApproverRequest;
use App\Http\Requests\VacationRequestUpdateRequest;
use App\Http\Resources\TeamResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\VacationRequestResource;
use App\Models\User;
use App\Models\Team;
use App\Models\Role;
use App\Models\VacationRequest;
use App\Models\VacationData;
use App\Models\Holiday;
use App\Events\ApproveVacationRequest;

class VacationRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user(User $user)
    {
        $user = User::with('team', 'vacationData')->find($user->id);
        $user = (new UserResource($user))->all(request());

        $vacation_requests = VacationRequest::where('user_id', $user['id'])->get();
        $vacation_requests = VacationRequestResource::collection($vacation_requests)->all(request());

        return view('vacations.requests.user')->with([
            'user' => $user,
            'vacation_requests' => $vacation_requests
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function team(Team $team)
    {
        $vacation_requests = VacationRequest::with('user.team', 'team.users', 'user.role')->where('team_id', $team->id)->get();
        $vacation_requests = VacationRequestResource::collection($vacation_requests)->all(request());

        $team = Team::with('users', 'projectManager', 'teamLead')->find($team->id);
        $team = (new TeamResource($team))->all(request());

        return view('vacations.requests.team')->with([
            'vacation_requests' => $vacation_requests,
            'team' => $team
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::with('team', 'vacationData')->find(auth()->id());
        $user = (new UserResource($user))->all(request());

        return view('vacations.requests.create')->with([
            'user' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VacationRequestStoreRequest $request)
    {
        $user = User::with('team', 'team.projectManager', 'team.teamLead')->find(auth()->id());
        $team_lead_id = data_get($user->team, 'team_lead_id');
        $project_manager_id = data_get($user->team, 'project_manager_id');

        $vacation_request = new VacationRequest;
        $vacation_request->user_id = $user->id;
        $vacation_request->team_id = data_get($user->team, 'id');
        $vacation_request->from = Carbon::parse($request->input('from'))->format('Y-m-d');
        $vacation_request->to = Carbon::parse($request->input('to'))->format('Y-m-d');
        $vacation_request->note = $request->input('note');

        $vacation_request->project_manager_status = VacationRequest::PENDING;
        if ($project_manager_id == $user->id || $project_manager_id == null) {
            $vacation_request->project_manager_status = VacationRequest::APPROVED;
        }

        $vacation_request->team_lead_status = VacationRequest::PENDING;
        if ($team_lead_id == $user->id || $team_lead_id == null) {
            $vacation_request->team_lead_status = VacationRequest::APPROVED;
        }

        $vacation_request->status = VacationRequest::PENDING;
        if(($project_manager_id == null || $project_manager_id == $user->id) && ($team_lead_id == null || $team_lead_id == $user->id)) {
            $vacation_request->team_lead_status = VacationRequest::ADMIN;
            $vacation_request->project_manager_status = VacationRequest::ADMIN;
            $vacation_request->status = VacationRequest::ADMIN;
        }

        $vacation_request->save();

        event(new CreatedVacationRequest($vacation_request, $user));

        return redirect()->route('vacations.requests.user', $vacation_request->user_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(VacationRequest $vacation_request)
    {
        $user = User::with('team', 'vacationData')->find($vacation_request->user_id);
        $user = (new UserResource($user))->all(request());

        $vacation_request = (new VacationRequestResource($vacation_request))->all(request());

        $role_slugs = [
            'approver' => Role::APPROVER,
            'admin' => Role::ADMIN,
        ];

        $status = [
            'approved' => VacationRequest::APPROVED,
            'pending' => VacationRequest::PENDING,
            'denied' => VacationRequest::DENIED
        ];

        return view('vacations.requests.show')->with([
            'user' => $user,
            'vacation_request' => $vacation_request,
            'status' => $status,
            'role_slugs' => $role_slugs
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(VacationRequest $vacation_request)
    {
        if ($vacation_request->project_manager_status == VacationRequest::APPROVED ||
            $vacation_request->lead_team_status == VacationRequest::APPROVED ||
            $vacation_request->lead_team_status == VacationRequest::DENIED ||
            $vacation_request->lead_team_status == VacationRequest::DENIED
        ) {
            return back();
        };

        $vacation_request = VacationRequest::with('user.team', 'user.vacationData', 'team.users', 'user.role')->find($vacation_request->id);
        $vacation_request = (new VacationRequestResource($vacation_request))->all(request());

        $user = $vacation_request['user'];

        return view('vacations.requests.edit')->with([
            'vacation_request' => $vacation_request,
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VacationRequestUpdateRequest $request, VacationRequest $vacation_request)
    {
        $vacation_request->from = Carbon::parse($request->input('from'))->format('Y-m-d');
        $vacation_request->to = Carbon::parse($request->input('to'))->format('Y-m-d');
        $vacation_request->note = $request->input('note');
        $vacation_request->save();

        event(new UpdatedVacationRequest($vacation_request));

        return redirect()->route('vacations.requests.user', $vacation_request->user_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(VacationRequest $vacation_request)
    {
        $vacation_request->delete();

        return redirect()->route('vacations.requests.user');
    }

    /**
     * Approve or deny vacation request
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve(VacationApproverRequest $request, VacationRequest $vacation_request)
    {
        $vacation_request = VacationRequest::with('user', 'team')->find($vacation_request->id);
        $vacation_data = VacationData::where('user_id', $vacation_request->user_id)->first();

        $user = auth()->user();
        $team_lead_id = data_get($vacation_request->team, 'team_lead_id');
        $project_manager_id = data_get($vacation_request->team, 'project_manager_id');
        $status = data_get($vacation_request, 'status');
        $team_lead_status = data_get($vacation_request, 'team_lead_status');
        $project_manager_status = data_get($vacation_request, 'project_manager_status');
        $project_manager_note = data_get($vacation_request, 'project_manager_note');
        $team_lead_note = data_get($vacation_request, 'team_lead_note');

        DB::beginTransaction();

        if ($request->input('accepted')) {

            if ($team_lead_id == $user->id) {
                $team_lead_status = VacationRequest::APPROVED;
                $team_lead_note = $request->input('approver_note');
            };

            if ($project_manager_id == $user->id) {
                $project_manager_status = VacationRequest::APPROVED;
                $project_manager_note = $request->input('approver_note');
            };

            if ($project_manager_status == VacationRequest::APPROVED && $team_lead_status == VacationRequest::APPROVED) {
                $status = VacationRequest::APPROVED;
            }

            if ($user->role->slug == Role::ADMIN && $user->id != $project_manager_id && $user->id != $team_lead_id) {
                $team_lead_status = VacationRequest::APPROVED;
                $project_manager_status = VacationRequest::APPROVED;
                $status = VacationRequest::APPROVED;
                $vacation_request->admin_note = $request->input('approver_note');
            }

            if($status == VacationRequest::APPROVED) {
                $holidays = Holiday::where('date', '>=', $vacation_request->from)->where('date', '<=', $vacation_request->to)->get();

                $from = Carbon::parse($vacation_request->from);
                $to = Carbon::parse($vacation_request->to)->addDays(1);
                $vacation_lenght = $to->diffInWeekdays($from);

                foreach ($holidays as $holiday) {
                    $holiday_carbon = Carbon::parse($holiday->date);
                    if ($holiday_carbon->isWeekday()) {
                        $vacation_lenght -= 1;
                    };
                };

                $vacation_data->unused_vacation -= $vacation_lenght;
                $vacation_request->used_vacation += $vacation_lenght;
                if($request->input('paid_leave')) {
                    $vacation_data->paid_leave += $vacation_lenght;
                    $vacation_data->unused_vacation += $vacation_lenght;
                    $vacation_request->used_vacation -= $vacation_lenght;
                };

                $vacation_data->save();

                event(new ApproveVacationRequest($vacation_request));
            };
        }

        if (!$request->input('accepted')) {

            if ($team_lead_id == auth()->id()) {
                $team_lead_status = VacationRequest::DENIED;
                $team_lead_note = $request->input('approver_note');
            };

            if ($project_manager_id == auth()->id()) {
                $project_manager_status = VacationRequest::DENIED;
                $project_manager_note = $request->input('approver_note');
            };

            if ($project_manager_status == VacationRequest::DENIED || $team_lead_status == VacationRequest::DENIED) {
                $status = VacationRequest::DENIED;
                event(new ApproveVacationRequest($vacation_request));
            }

            if ($user->role->slug == Role::ADMIN && $user->id != $project_manager_id && $user->id != $team_lead_id) {
                $team_lead_status = VacationRequest::DENIED;
                $project_manager_status = VacationRequest::DENIED;
                $status = VacationRequest::DENIED;
                $vacation_request->admin_note = $request->input('approver_note');
                event(new ApproveVacationRequest($vacation_request));
            }
        }

        if (
            $status == VacationRequest::DENIED &&
            $project_manager_status != VacationRequest::DENIED &&
            $team_lead_status != VacationRequest::DENIED
        ) {
            $status = VacationRequest::PENDING;
        }

        $vacation_request->project_manager_status = $project_manager_status;
        $vacation_request->project_manager_note = $project_manager_note;
        $vacation_request->team_lead_status = $team_lead_status;
        $vacation_request->team_lead_note = $team_lead_note;
        $vacation_request->status = $status;
        $vacation_request->save();

        DB::commit();

        return redirect()->route('vacations.requests.show', $vacation_request->id);
    }
}

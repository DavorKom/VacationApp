<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

class VacationRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user(User $user)
    {
        $user = User::with('team')->find($user->id);
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
        return view('vacations.requests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VacationRequestStoreRequest $request)
    {
        $user = auth()->user();

        $vacation_request = new VacationRequest;
        $vacation_request->user_id = $user->id;
        $vacation_request->team_id = $user->team->id;
        $vacation_request->from = Carbon::parse($request->input('from'))->format('Y-m-d');
        $vacation_request->to = Carbon::parse($request->input('to'))->format('Y-m-d');
        $vacation_request->note = $request->input('note');

        $vacation_request->project_manager_status = VacationRequest::PENDING;
        if ($user->team->project_manager_id == $user->id || $user->team->project_manager_id == null) {
            $vacation_request->project_manager_status = VacationRequest::APPROVED;
        }

        $vacation_request->team_lead_status = VacationRequest::PENDING;
        if ($user->team->team_lead_id == $user->id || $user->team->team_lead == null) {
            $vacation_request->team_lead_status = VacationRequest::APPROVED;
        }

        $vacation_request->status = VacationRequest::PENDING;
        $vacation_request->save();

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
        $user = User::with('team')->find($vacation_request->user_id);
        $user = (new UserResource($user))->all(request());

        $vacation_request = (new VacationRequestResource($vacation_request))->all(request());

        $approver_slug = Role::APPROVER;

        return view('vacations.requests.show')->with([
            'user' => $user,
            'vacation_request' => $vacation_request,
            'approver_slug' => $approver_slug
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
        $vacation_request = VacationRequest::with('user.team', 'team.users', 'user.role')->find($vacation_request->id);
        $vacation_request = (new VacationRequestResource($vacation_request))->all(request());

        return view('vacations.requests.edit')->with([
            'vacation_request' => $vacation_request
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

    public function approve(VacationApproverRequest $request, VacationRequest $vacation_request)
    {
        if ($vacation_request->team_lead_id == auth()->user()->id) {
            $vacation_request->team_lead_status = VacationRequest::APPROVED;
            $vacation_request->team_lead_note = $request->input('approver_note');
        };

        if ($vacation_request->project_manager_id == auth()->user()->id) {
            $vacation_request->project_manager_status = VacationRequest::APPROVED;
            $vacation_request->project_manager_note = $request->input('approver_note');
        };

        if ($vacation_request->project_manager_status == VacationRequest::APPROVED && $vacation_request->team_lead_status == VacationRequest::APPROVED) {
            $vacation_request->status = VacationRequest::APPROVED;
        }

        return redirect()->route('vacations.requests.show', $vacation_request->id);
    }

    public function deny(VacationApproverRequest $request, VacationRequest $vacation_request)
    {
        if ($vacation_request->team_lead_id == auth()->user()->id) {
            $vacation_request->team_lead_status = VacationRequest::DENIED;
            $vacation_request->team_lead_note = $request->input('approver_note');
        };

        if ($vacation_request->project_manager_id == auth()->user()->id) {
            $vacation_request->project_manager_status = VacationRequest::DENIED;
            $vacation_request->project_manager_note = $request->input('approver_note');
        };

        if ($vacation_request->project_manager_status == VacationRequest::DENIED || $vacation_request->team_lead_status == VacationRequest::DENIED) {
            $vacation_request->status = VacationRequest::DENIED;
        }

        $vacation_request->save();

        return redirect()->route('vacations.requests.show', $vacation_request->id);
    }
}

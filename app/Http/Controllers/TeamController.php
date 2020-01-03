<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Team;
use App\Models\Role;
use App\Http\Resources\UserResource;
use App\Http\Resources\TeamResource;
use App\Http\Requests\TeamStoreRequest;
use App\Http\Requests\TeamUpdateRequest;
use Illuminate\Log\Logger;


class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with('projectManager.team', 'teamLead.team', 'users.team')->get();
        $teams = TeamResource::collection($teams)->all(request());

        return view('teams.index')->with([
            'teams' => $teams
        ]);
    }

    public function show(Team $team)
    {
        $this->authorize('view', $team);

        $team = Team::with('projectManager.team', 'teamLead.team', 'users.team')->find($team->id);
        $team = (new TeamResource($team))->all(request());

        return view('teams.show')->with([
            'team' => $team
        ]);
    }

    public function store(TeamStoreRequest $request)
    {
        $approver_role = Role::where('slug', Role::APPROVER)->first();

        $team = new Team;
        $team->name = $request->input('name');
        $team->project_manager_id = $request->input('project_manager_id');
        if ($request->input('project_manager_id') != null) {
            $project_manager = User::find($request->input('project_manager_id'));
            $project_manager->role_id = $approver_role->id;
            $project_manager->save();
        }
        $team->team_lead_id = $request->input('team_lead_id');
        if ($request->input('team_lead_id') != null) {
            $team_lead = User::find($request->input('team_lead_id'));
            $team_lead->role_id = $approver_role->id;
            $team_lead->save();
        }
        $team->save();

        return redirect()->route('teams.index');
    }

    public function create()
    {
        $users = User::with('team')->get();
        $users = UserResource::collection($users)->all(request());

        return view('teams.create')->with([
            'users' => $users,
        ]);
    }

    public function edit(Team $team)
    {
        $users = User::with('team')->get();
        $users = UserResource::collection($users)->all(request());

        return view('teams.edit')->with([
            'team' => $team,
            'users' => $users,
        ]);
    }

    public function update(TeamUpdateRequest $request, Team $team)
    {
        DB::beginTransaction();

        $roles = Role::all()->keyBy('slug');

        $team->name = $request->input('name');
        if ($request->input('project_manager_id') != null) {
            if ($team->project_manager_id != null) {
                $old_project_manager = User::withCount('teamProjectManager', 'teamTeamLead')->find($team->project_manager_id);
                $approver_count = $old_project_manager->team_team_lead_count + $old_project_manager->team_project_manager_count;
                if($approver_count <= 1 && $old_project_manager->role_id != $roles[Role::ADMIN]->id) {
                    $old_project_manager->role_id = $roles[Role::EMPLOYEE]->id;
                    $old_project_manager->save();
                }
            }
            $project_manager = User::find($request->input('project_manager_id'));
            if ($project_manager->role_id != $roles[Role::ADMIN]->id) {
                $project_manager->role_id = $roles[Role::APPROVER]->id;
                $project_manager->save();
            }
        }
        $team->project_manager_id = $request->input('project_manager_id');

        if ($request->input('team_lead_id') != null) {
            if ($team->team_lead_id != null) {
                $old_team_lead = User::withCount('teamProjectManager', 'teamTeamLead')->find($team->team_lead_id);
                $approver_count = $old_team_lead->team_team_lead_count + $old_team_lead->team_project_manager_count;
                if($approver_count <= 1 && $old_team_lead->role_id != $roles[Role::ADMIN]->id) {
                    $old_team_lead->role_id = $roles[Role::EMPLOYEE]->id;
                    $old_team_lead->save();
                }
            }
            $team_lead = User::find($request->input('team_lead_id'));
            if ($team_lead->role_id != $roles[Role::ADMIN]->id) {
                $team_lead->role_id = $roles[Role::APPROVER]->id;
                $team_lead->save();
            }
        }
        $team->team_lead_id = $request->input('team_lead_id');
        $team->save();

        DB::commit();

        return redirect()->route('teams.show', $team->id);
    }

    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()->route('teams.index');
    }
}

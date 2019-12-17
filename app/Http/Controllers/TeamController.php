<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Team;
use App\Http\Resources\UserResource;
use App\Http\Resources\TeamResource;
use App\Http\Requests\TeamStoreRequest;
use App\Http\Requests\TeamUpdateRequest;

class TeamController extends Controller
{

    public function index()
    {   
        $teams = Team::with('projectManager', 'teamLead', 'projectManager.teams', 'teamLead.teams', 'users', 'users.teams')->get();
        $teams = TeamResource::collection($teams)->all(request());

        return view('teams.index')->with([
            'teams' => $teams
        ]);
    }

    public function show(Team $team)
    {
        $team = Team::with('projectManager', 'teamLead', 'projectManager.teams', 'teamLead.teams', 'users', 'users.teams')->find($team->id);
        $team = (new TeamResource($team))->all(request());

        return view('teams.show')->with([
            'team' => $team
        ]);
    }

    public function store(TeamStoreRequest $request)
    {
        $team = new Team;
        $team->name = $request->input('name');
        $team->project_manager_id = $request->input('project_manager_id');
        $team->team_lead_id = $request->input('team_lead_id');
        $team->save();

        return redirect()->route('teams.index');
    }

    public function create()
    {
        $users = User::with('teams')->get();
        $users = UserResource::collection($users)->all(request());

        return view('teams.create')->with([
            'users' => $users,
        ]);
    }

    public function edit(Team $team)
    {   
        $users = User::with('teams')->get();
        $users = UserResource::collection($users)->all(request());

        return view('teams.edit')->with([
            'team' => $team,
            'users' => $users,
        ]);
    }

    public function update(TeamUpdateRequest $request, Team $team)
    {
        $team->name = $request->input('name');
        $team->project_manager_id = $request->input('project_manager_id');
        $team->team_lead_id = $request->input('team_lead_id');
        $team->save();

        return redirect()->route('teams.index');
    }

    public function delete(Team $team)
    {
        $team->delete();

        return redirect()->route('teams.index');
    }
}

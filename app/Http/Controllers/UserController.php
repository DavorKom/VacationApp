<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Role;
use App\Models\Team;
use App\Events\CreatedUser;
use App\Events\CreatingUser;
use App\Events\UpdatingUser;
use App\Events\UpdatedUser;
use App\Http\Resources\UserResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\TeamResource;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = null;
        $order_by = 'id';
        $sort_by = 'asc';
        $from = Carbon::createFromDate(1900, 1, 1);
        $to = Carbon::now();

        if ($request->input('search')) {
            $search = $request->query('search');
        }

        if ($request->input('order_by')) {
            $order_by = $request->query('order_by');
        }

        if ($request->input('sort_by')) {
            $sort_by = $request->query('sort_by');
        }

        if ($request->input('from')) {
            $from = $request->query('from');
        }

        if ($request->input('to')) {
            $to = $request->query('to');
        }

        $order_by_filters = [
            'id' => 'ID',
            'first_name' => 'Ime',
            'last_name' => 'Prezime'
        ];

        $users = User::search($search)->orderBy($order_by, $sort_by)->whereDate('contract_date', '>=', $from)
            ->whereDate('contract_date', '<=', $to)->with('team')->get();
        $users = UserResource::collection($users)->all(request());

        return view('users.index')->with([
            'users' => $users,
            'order_by_filters' => $order_by_filters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $roles = RoleResource::collection($roles)->all(request());

        $teams = Team::with('projectManager.team', 'teamLead.team', 'users.team')->get();
        $teams = TeamResource::collection($teams)->all(request());

        return view('users.create')->with([
            'roles' => $roles,
            'teams' => $teams
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        event(new CreatingUser());

        $user = new User;
        $user->role_id = $request->input('role_id');
        $user->team_id = $request->input('team_id');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->contract_date = Carbon::parse($request->input('contract_date'))->format('Y-m-d');
        $user->save();

        event(new CreatedUser($user));

        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user = User::with('role', 'team')->find($user->id);
        $user = (new UserResource($user))->all(request());

        $roles = Role::all();
        $roles = RoleResource::collection($roles)->all(request());

        $teams = Team::with('projectManager.team', 'teamLead.team', 'users.team')->get();
        $teams = TeamResource::collection($teams)->all(request());

        return view('users.edit')->with([
            'user' => $user,
            'roles' => $roles,
            'teams' => $teams
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        event(new UpdatingUser($user));

        $user->role_id = $request->input('role_id');
        $user->team_id = $request->input('team_id');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->contract_date = Carbon::parse($request->input('contract_date'))->format('Y-m-d');
        $user->save();

        event(new UpdatedUser($user));

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}

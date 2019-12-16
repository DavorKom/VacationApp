<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
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
    public function index()
    {   
        $user = (new UserResource(User::find(1)))->toArray(request());

        $users = UserResource::collection(User::all())->toArray(request());

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $roles = Role::where('slug', '!=', Role::ADMIN)->get();

        $roles = RoleResource::collection($roles)->toArray(request());

        return view('users.create')->with([
            'roles' => $roles
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
        $user = User::with('role')->find($user->id);

        $user = (new UserResource($user))->toArray(request());

        $roles = Role::where('slug', '!=', Role::ADMIN)->get();

        $roles = RoleResource::collection($roles)->toArray(request());

        return view('users.edit')->with([
            'user' => $user,
            'roles' => $roles
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

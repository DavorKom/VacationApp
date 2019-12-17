@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control" name='first_name' value="{{ old('first_name') }}" placeholder="First Name" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name='last_name' value="{{ old('last_name') }}" placeholder="Last Name" required>
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-mail" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name='password' placeholder="Password" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name='password_confirmation' placeholder="Confirm Password" required>
        </div>
        <div class="form-group">
            <select name="role_id" class="form-control" required>
                @foreach($roles as $role)
                    <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <select name="team_id" class="form-control">
                <option value="{{ null }}">Odaberi Tim:</option>
                @foreach($teams as $team)
                    <option value="{{ $team['id'] }}">{{ $team['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <input type="date" class="form-control" name="contract_date" value="{{ old('contract_date') }}" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('users.update', [$user['id']]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <input type="text" class="form-control" name='first_name' value="{{ $user['first_name'] }}" placeholder="First Name" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name='last_name' value="{{ $user['last_name'] }}" placeholder="Last Name" required>
        </div>
        <div class="form-group">
            <select name="role_id" class="form-control" required>
                @foreach($roles as $role)
                    <option value="{{ $role['id'] }}" @if($user['role']['slug'] == $role['slug']) selected="selected" @endif>{{ $role['name'] }}</option>
                @endforeach
            </select>
        </div>
        @foreach($user['teams'] as $user_team)
        <div class="form-group">
            <select name="team_id" class="form-control">
                <option value="{{ null }}">Odaberi Tim:</option>
                @foreach($teams as $team)
                    <option value="{{ $team['id'] }}" @if($user_team['id'] == $team['id']) selected="selected" @endif>{{ $team['name'] }}</option>
                @endforeach
            </select>
        </div> 
        @endforeach
        <div class="form-group">
            <input type="date" class="form-control" name="contract_date" value="{{ $user['contract_date']['datepicker'] }}" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection

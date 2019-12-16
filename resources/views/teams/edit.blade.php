@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('teams.update', [$team['id']]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <input type="text" class="form-control" name='name' value="{{ $team['name'] }}" placeholder="Team Name" required>
        </div>
        <div class="form-group">
            <select name="project_manager_id" class="form-control" required>
                <option value="0" @if( 0 == $team['project_manager_id']) selected="selected" @endif></option>
                @foreach($users as $user)
                    <option value="{{ $user['id'] }}" @if($user['id'] == $team['project_manager_id']) selected="selected" @endif>{{ $user['id']. ' - ' .$user['full_name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <select name="team_lead_id" class="form-control" required>
                <option value="0" @if( 0 == $team['team_lead_id']) selected="selected" @endif></option>
                @foreach($users as $user)
                    <option value="{{ $user['id'] }}" @if($user['id'] == $team['team_lead_id']) selected="selected" @endif>{{ $user['id']. ' - ' .$user['full_name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('teams.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control" name='name' value="{{ old('name') }}" placeholder="Team Name" required>
        </div>
        <div class="form-group">
            <select name="project_manager_id" class="form-control">
                <option value={{ null }}>Odaberi Project Managera:</option>
                @foreach($users as $user)
                    <option value="{{ $user['id'] }}">{{ $user['id']. ' - ' .$user['full_name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <select name="team_lead_id" class="form-control">
                    <option value="{{ null }}">Odaberi Team Leada:</option>
                @foreach($users as $user)
                    <option value="{{ $user['id'] }}">{{ $user['id']. ' - ' .$user['full_name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection
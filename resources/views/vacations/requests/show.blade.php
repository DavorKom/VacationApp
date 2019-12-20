@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $vacation_request['id'] }} - Vacation request:
        @if(auth()->id() == $vacation_request['user']['id'] && $vacation_request['project_manager_status'] == $status['pending'] && $vacation_request['team_lead_status'] == $status['pending'])
            <a href="{{ route('vacations.requests.edit', [$vacation_request['id']]) }}" class="btn btn-primary">Edit</a>
        @endif
        @if ($vacation_request['status'] === $status['approved'])
            <span class="btn-lg btn-success float-right">Appproved</span>
        @elseif ($vacation_request['status'] === $status['denied'])
            <span class="btn-lg btn-danger float-right">Denied</span>
        @else
            <span class="btn-lg btn-warning float-right">Pending</span>
        @endif
    </h2>
    <div class="form-group">
        <label for="from">From:</label>
        <h4>{{ $vacation_request['from']['standard'] }}</h4>
    </div>
    <div class="form-group">
        <label for="from">To:</label>
        <h4>{{ $vacation_request['to']['standard'] }}</h4>
    </div>
    <div class="alert alert-secondary">
        <h5>Employee note:</h5>
        <p>{{ $vacation_request['note'] }}</p>
    </div>
    @if (!is_null($vacation_request['project_manager_note']))
    <div class="alert alert-secondary">
        <h5>Project Manager note:
            @if ($vacation_request['project_manager_status'] === $status['approved'])
                <span class="btn-sm btn-success float-right">Appproved</span>
            @elseif ($vacation_request['project_manager_status'] === $status['denied'])
                <span class="btn-sm btn-danger float-right">Denied</span>
            @else
                <span class="btn-sm btn-warning float-right">Pending</span>
            @endif
        </h5>
        <p>{{ $vacation_request['project_manager_note'] }}</p>
    </div>
    @endif
    @if (!is_null($vacation_request['team_lead_note']))
    <div class="alert alert-secondary">
        <h5>Team Lead note:
            @if ($vacation_request['team_lead_status'] === $status['approved'])
                <span class="btn-sm btn-success float-right">Appproved</span>
            @elseif ($vacation_request['team_lead_status'] === $status['denied'])
                <span class="btn-sm btn-danger float-right">Denied</span>
            @else
                <span class="btn-sm btn-warning float-right">Pending</span>
            @endif
        </h5>
        <p>{{ $vacation_request['team_lead_note'] }}</p>
    </div>
    @endif
    @if (auth()->user()->role->slug = $approver_slug && $vacation_request['status'] != $status['approved'])
    <div class="form-group">
        <form action="{{ route('vacations.requests.approve', [$vacation_request['id']]) }}" method="POST">
            @csrf
            <textarea name="approver_note" class="form-control" cols="30" rows="3" placeholder="Note..."></textarea>
            <div class="mt-2">
                <button name="accepted" class="btn btn-success" type="submit" value="1">Approve</button>
                <button name="accepted" class="btn btn-danger" type="submit" value="0">Deny</button>
            </div>
        </form>
    </div>
    @endif
</div>
@endsection
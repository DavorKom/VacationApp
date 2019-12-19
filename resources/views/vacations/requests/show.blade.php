@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $vacation_request['id'] }} - Vacation request:</h2>
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
    @if(!is_null($vacation_request['project_manager_note']))
    <div class="alert alert-secondary">
        <h5>Project Manager note:</h5>
        <p>{{ $vacation_request['project_manager_note'] }}</p>
    </div>
    @endif
    @if(!is_null($vacation_request['team_lead_note']))
    <div class="alert alert-secondary">
        <h5>Team Lead note:</h5>
        <p>{{ $vacation_request['team_lead_note'] }}</p>
    </div>
    @endif
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn-lg btn-primary text-decoration-none">Back</a>
    </div>
    <h2>Tim:</h2>
    <table class="table">
        <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Ime</th>
                    <th scope="col">Project Manager</th>
                    <th scope="col">Team Lead</th>
                </tr>
        </thead>
        <tbody>
                <tr>
                    <td>{{ $team['id'] }}</td>
                    <td>{{ $team['name'] }}</td>
                    <td>{{ $team['project_manager']['full_name'] }}</td>
                    <td>{{ $team['team_lead']['full_name'] }}</td>
                </tr>
        </tbody>
    </table>
</div>
<div class="container mb-3">
    <a class="btn btn-primary" href="{{ route('teams.show', [$team['id']]) }}" >Članovi tima</a>
</div>
<div class="container">
    <h2>Zahtjevi za godišnji odmor</h2>
    <table class="table">
        <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Od</th>
                    <th scope="col">Do</th>
                    <th scope="col">Iskoršteni godišnji</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
        </thead>
        <tbody>
                @foreach ($vacation_requests as $vacation_request)
                <tr>
                    <td>{{ $vacation_request['id'] }}</td>
                    <td>{{ $vacation_request['from']['standard'] }}</td>
                    <td>{{ $vacation_request['to']['standard'] }}</td>
                    <td>{{ $vacation_request['used_vacation'] }}</td>
                    <td>{{ $vacation_request['status'] }}</td>
                </tr>
                @endforeach
        </tbody>
    </table>
</div>
@endsection
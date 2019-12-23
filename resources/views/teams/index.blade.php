@extends('layouts.app')

@section('content')
<div class="container mb-3">
    <a class="btn btn-primary" href="{{ route('users.create') }}">Novi korisnik</a>
    <a class="btn btn-primary" href="{{ route('teams.create') }}">Novi tim</a>
    <a class="btn btn-primary float-right" href="{{ route('users.index') }}">Korisnici</a>
</div>
<div class="container">
    <table class="table">
    <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Ime</th>
                <th scope="col">Project Manager</th>
                <th scope="col">Team Lead</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
    </thead>
    <tbody>
            @foreach($teams as $team)
            <tr>
                <th scope="row">{{ $team['id'] }}</th>
                <td>{{ $team['name'] }}</td>
                <td>{{ $team['project_manager']['full_name'] }}</td>
                <td>{{ $team['team_lead']['full_name'] }}</td>
                <td>
                    <a class="btn btn-primary" href="{{ route('teams.show', [$team['id']]) }}">Show</a>
                </td>
                <td>
                    <form action="{{ route('teams.delete', [$team['id']]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
    </tbody>
    </table>
</div>
@endsection
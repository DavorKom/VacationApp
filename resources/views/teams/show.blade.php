@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Tim</h2>
  <table class="table">
    <thead>
          <tr>
              <th scope="col">ID</th>
              <th scope="col">Ime</th>
              <th scope="col">Project Manager</th>
              <th scope="col">Team Lead</th>
              <th scope="col"></th>
          </tr>
    </thead>
    <tbody>
          <tr>
              <th scope="row">{{ $team['id'] }}</th>
              <td>{{ $team['name'] }}</td>
              <td>{{ $team['project_manager']['full_name'] }}</td>
              <td>{{ $team['team_lead']['full_name'] }}</td>
              <td></td>
          </tr>
    </tbody>
  </table>
</div>
<div class="container mb-3">
    <a class="btn btn-primary" href="{{ route('vacations.requests.team', [$team['id']]) }}" >Zahtjevi za GO</a>
</div>
<div class="container">
  <h2>Članovi tima</h2>
  <table class="table">
    <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Ime</th>
            <th scope="col">Prezime</th>
            <th scope="col">E-mail</th>
            <th scope="col">Početka rada</th>
            <th scope="col"></th>
          </tr>
    </thead>
    <tbody>
          @foreach ($team['users'] as $user)
          <tr>
              <th scope="row">{{ $user['id'] }}</th>
              <td>{{ $user['first_name'] }}</td>
              <td>{{ $user['last_name'] }}</td>
              <td>{{ $user['email'] }}</td>
              <td>{{ $user['contract_date']['standard'] }}</td>
              <td></td>
          </tr>
          @endforeach
    </tbody>
  </table>
</div>
@endsection
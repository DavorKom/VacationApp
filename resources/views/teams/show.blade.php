@extends('layouts.app')

@section('content')
<div class="container">
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
@endsection
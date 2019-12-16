@extends('layouts.app')

@section('content')
<div class="container">
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
        @foreach($users as $user)
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
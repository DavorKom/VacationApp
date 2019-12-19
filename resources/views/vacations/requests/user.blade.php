@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Prostor za podatke korisnika --}}
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
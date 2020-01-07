@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn-lg btn-primary text-decoration-none">Back</a>
    </div>
    <table class="table">
        <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Ime</th>
                    <th scope="col">Prezime</th>
                    <th scope="col">Contract Date</th>
                    <th scope="col">Unused Vacation</th>
                    <th scope="col">Used Vacation</th>
                    <th scope="col">Paid Leave</th>
                    <th scope="col"></th>
                </tr>
        </thead>
        <tbody>
                <tr>
                    <td>{{ $user['id'] }}</td>
                    <td>{{ $user['first_name'] }}</td>
                    <td>{{ $user['last_name'] }}</td>
                    <td>{{ $user['contract_date']['standard'] }}</td>
                    <td>{{ $user['vacation_data']['unused_vacation'] }}</td>
                    <td>{{ $user['vacation_data']['used_vacation'] }}</td>
                    <td>{{ $user['vacation_data']['paid_leave'] }}</td>
                    <th>
                        @if (!is_null($user['vacation_data']['id']))
                            <a href="{{ route('vacations.data.edit', [$user['vacation_data']['id']]) }}" class="btn btn-primary">Edit Vacation Data</a>
                        @endif
                    </th>
                </tr>
        </tbody>
    </table>
    <div class="mb-3">
        <a href="{{ route('vacations.requests.create') }}" class="btn-lg btn-primary text-decoration-none">Create Vacation Request</a>
    </div>
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
                    <th>
                        <a href="{{ route('vacations.requests.show', [$vacation_request['id']]) }}" class="btn btn-primary">Show</a>
                    </th>
                    <th>
                        @if (auth()->id() == $user['id'])
                            <form action="{{ route('vacations.requests.delete', [$vacation_request['id']]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        @endif
                    </th>
                </tr>
                @endforeach
        </tbody>
    </table>
</div>
@endsection
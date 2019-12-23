@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-2">
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
                </tr>
        </tbody>
    </table>
    <form action="{{ route('vacations.requests.store') }}" method="POST">
        @csrf
        <h2>Create vacation request:</h2>
        <div class="form-group">
            <label for="from">From:</label>
            <input type="date" class="form-control" name="from" value="{{ old('to') }}">
        </div>
        <div class="form-group">
            <label for="from">To:</label>
            <input type="date" class="form-control" name="to" value="{{ old('from') }}">
        </div>
        <div class="form-group">
            <label for="note">Note:</label>
            <textarea name="note" class="form-control">{{ old('note') }}</textarea>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
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
                    <td>{{ $vacation_request['id'] }}</td>
                    <td>{{ $vacation_request['first_name'] }}</td>
                    <td>{{ $vacation_request['last_name'] }}</td>
                    <td>{{ $vacation_request['contract_date']['standard'] }}</td>
                    <td>{{ $vacation_request['vacation_data']['unused_vacation'] }}</td>
                    <td>{{ $vacation_request['vacation_data']['used_vacation'] }}</td>
                    <td>{{ $vacation_request['vacation_data']['paid_leave'] }}</td>
                </tr>
        </tbody>
    </table>
    <form action="{{ route('vacations.requests.update', [$vacation_request['id']]) }}" method="POST">
        @csrf
        @method('PUT')
        <h2>Create vacation request:</h2>
        <div class="form-group">
            <label for="from">From:</label>
            <input type="date" class="form-control" name="from" value="{{ $vacation_request['from']['datepicker'] }}">
        </div>
        <div class="form-group">
            <label for="from">To:</label>
            <input type="date" class="form-control" name="to" value="{{ $vacation_request['to']['datepicker'] }}">
        </div>
        <div class="form-group">
            <label for="note">Note:</label>
            <textarea name="note" class="form-control">{{ $vacation_request['note'] }}</textarea>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection
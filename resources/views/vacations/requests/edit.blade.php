@extends('layouts.app')

@section('content')
<div class="container">
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
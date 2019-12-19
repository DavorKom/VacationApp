@extends('layouts.app')

@section('content')
<div class="container">
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
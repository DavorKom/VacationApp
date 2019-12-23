@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-2">
        <a href="{{ url()->previous() }}" class="btn-lg btn-primary text-decoration-none">Back</a>
    </div>
    <form action="{{ route('vacations.data.update', [$vacation_data['id']] ) }}" method="POST">
        @csrf
        @method('PUT')
        <h2>Update vacation data:</h2>
        <div class="form-group">
            <label for="unused_vacation">Unused vacation:</label>
            <input type="number" class="form-control" name="unused_vacation" value="{{ $vacation_data['unused_vacation'] }}">
        </div>
        <div class="form-group">
            <label for="used_vacation">Used vacation:</label>
            <input type="number" class="form-control" name="used_vacation" value="{{ $vacation_data['used_vacation'] }}">
        </div>
        <div class="form-group">
            <label for="paid_leave">Paid leave</label>
            <input type="number" class="form-control" name="paid_leave" value="{{ $vacation_data['paid_leave'] }}">
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection
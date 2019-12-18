@extends('layouts.app')

@section('content')
<div class="container mb-3">
    <a class="btn btn-primary" href="{{ route('users.create') }}">Novi korisnik</a>
    <a class="btn btn-primary" href="{{ route('teams.create') }}">Novi tim</a>
</div>
<div class="container mb-1">
    <form action="{{ route("users.index") }}" method="get">
        <div class="row">
            <div class="form-group col-sm-4">
                <label for="search">Search:</label>
                <input type="search" class="form-control" name="search" value="{{ request()->query('search') }}" placeholder="Search">
            </div>
            <div class="form-group col-sm-4">
                <label for="order_by">Order by:</label>
                <select name="order_by" class="form-control">
                    @foreach($order_by_filters as $key => $order_by_filter)
                        <option value="{{ $key }}" @if(request()->query('order_by') == $key) selected="selected" @endif>{{ $order_by_filter }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="sort_by">Sort by:</label>
                <select name="sort_by" class="form-control">
                    <option value="asc" @if(request()->query('sort_by') == "asc") selected="selected" @endif>ASC</option>
                    <option value="desc" @if(request()->query('sort_by') == "desc") selected="selected" @endif>DESC</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="from">From:</label>
                <input type="date" class="form-control" name="from" value="{{ request()->query('from') }}">
            </div>
            <div class="form-group col-sm-4">
                <label for="to">To:</label>
                <input type="date" class="form-control" name="to" value="{{ request()->query('to') }}">
            </div>
            <div class="form-group col-sm-4">
                <button type="submit" class="btn btn-primary mt-4">Search</button>
            </div>
        </div>
    </form>
</div>
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
            <td>
                <form action="{{ route('users.delete', [$user['id']]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr> 
        @endforeach
  </tbody>
</table>
</div>
@endsection
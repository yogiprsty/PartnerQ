@extends('layouts.app')

@section('content')
@if (session('success'))
    <div>
        {{ session('success') }}
    </div>
@endif

<form action="/profile" method="post">
    @csrf
    <label for="">Fullname</label>
    <input type="text" name="fullname" value="{{ $user['fullname'] }}"><br>
    <label for="">Phone Number</label>
    <input type="text" name="phone" value="{{ $user['phone'] }}"><br>
    <label for="">Address</label>
    <input type="text" name="address" value="{{ $user['address'] }}"><br>
    <button type="submit">Update Profile</button>
</form>
@endsection
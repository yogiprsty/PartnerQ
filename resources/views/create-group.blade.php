@extends('layouts.app')

@section('content')
    <h1>Add Group</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="/group/create" method="POST">
        @csrf
        <label for="">Group name</label>
        <input type="text" name="name"><br>
        <label for="">Group Type</label><br>
        <input type="radio" name="type" id="" value="Spotify">
        <label for="">Spotify</label><br>
        <input type="radio" name="type" id="" value="Netflix">
        <label for="">Netflix</label><br>
        <label for="">Group Desc</label><br>
        <textarea name="desc" id="" cols="30" rows="10"></textarea><br>
        <button type="submit">Add group</button>
    </form>
@endsection

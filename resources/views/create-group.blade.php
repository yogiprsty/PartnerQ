@extends('layouts.app')

@section('content')
<section id="forms">
    <div class="container-lg">
        <h2>Add Group</h2>
        <p class="lead">Start your path with making a group</p>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="row justify-content-center my-6">

    </div>

    <form action="/group/create" method="POST">
        @csrf
        <div class="row mb-3">
            <label for="" class="col-sm-2 col-form-label">Group name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name">
            </div>
        </div>
        <fieldset class="row mb-3">
            <legend class="col-form-label col-sm-2 pt-0">Group Type</legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type" id="gridRadios1" value="Spotify" checked>
                    <label class="form-check-label" for="gridRadios1">
                        Spotify
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type" id="gridRadios2" value="Netflix">
                    <label class="form-check-label" for="gridRadios2">
                        Netflix
                    </label>
                </div>
            </div>
        </fieldset>
        <div class="form-floating">
            <label for="" class="col-sm-2 col-form-label">Group Desciption</label>
            <textarea class="form-control" name="desc" id="" placeholder="Leave a description here"></textarea>
            <small id="passwordHelpBlock" class="form-text text-muted">
                Your desc maximum have 255 character
            </small>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Add group</button>
    </form>
</section>
@endsection
@extends('layouts.app')
@section('content')

    <div class="card shadow">
        <div class="card-header">{{ __('Public Group') }}</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form action="/home" method="get" class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Input keyword" name="name">
                <div class="input-group-append">
                    <select name="type" class="custom-select">
                        <option selected value="">Group Type</option>
                        <option value="Spotify">Spotify</option>
                        <option value="Netflix">Netflix</option>
                    </select>
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
            <div class="row container justify-content-around">
                <div class="row">
                    @foreach ($groups as $group)
                        <div class="col-md-4">
                            <div class="card my-2 bg-light shadow-sm">
                                <div class="card-header font-weight-bold">{{ $group->name }} |
                                    {{ $group->type }}</div>
                                <div class="card-body">
                                    <p class="card-text text-muted">Owner : {{ $group->owners[0]->username }}</p>
                                    <p class="card-text">{{ $group->desc }}</p>
                                    <form action="group/make-request/" method="POST">
                                        @csrf
                                        <input type="hidden" name="group_id" value={{ $group->id }}>
                                        <button class="btn btn-primary" type="submit">Request Join</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

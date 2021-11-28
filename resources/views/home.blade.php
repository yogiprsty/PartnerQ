@extends('layouts.app')
@section('content')
    <div>
        <div class="row justify-content-center px-4">
            <div class="col-md-3">
                <h5>Sidebar</h5>
                <ul>
                    <li><a href="/group/create">create group</a></li>
                </ul>
                <h5>Owned Group</h5>
                <ul>
                    @forelse ($user->owned_groups as $group)
                        <li><a href="/group/settings/{{ $group->slug }}">{{ $group->name }}</a></li>
                    @empty
                        <li>No Group</li>
                    @endforelse
                </ul>
                <h5>My Group</h5>
                <ul>
                    @forelse ($user->my_groups as $group)
                        <li><a href="/group/settings/{{ $group->slug }}">{{ $group->name }}</a></li>
                    @empty
                        <li>No Group</li>
                    @endforelse
                </ul>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">{{ __('Public Group') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="" method="GET">
                            <input type="text" placeholder="Search Group" name="group_name">
                            <button>Search</button>
                        </form>
                        <ul class="pt-3">
                            @foreach ($groups as $group)
                                <li>
                                    {{ $group->name }} | {{ $group->owners[0]->username }}
                                        <form action="group/make-request/" method="POST">
                                            @csrf
                                            <input type="hidden" name="group_id" value={{ $group->id }}>
                                            <button type="submit">Request Join</button>
                                        </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

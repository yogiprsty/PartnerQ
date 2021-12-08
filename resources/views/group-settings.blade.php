@extends('layouts.app')

@section('content')
    <div class="overflow-scroll" style="height: 2000px">
        <div class="card mb-3 shadow">
            <div class="card-header">{{ __('Group Settings') }}</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="/group/update" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $group->id }}">
                    <div class="mb-3 row">
                        <label for="inputName" class="col-sm-2 col-form-label">Group Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputName" name="name" value="{{ $group->name }}">
                        </div>
                    </div>
                    <label for="">Group Type : {{ $group->type }}</label><br>
                    <input type="radio" name="type" value="Spotify">
                    <label for="">Spotify</label><br>
                    <input type="radio" name="type" value="Netflix">
                    <label for="">Netflix</label><br>
                    <label for="">Group Desc</label><br>
                    <textarea name="desc" id="" cols="30" rows="10">{{ $group->desc }}</textarea><br>
                    <button type="submit">Edit group</button>
                </form>
            </div>
        </div>
        <div class="card mb-3 shadow">
            <div class="card-header">{{ __('Pending User') }}</div>
            <div class="card-body">
                <table border="1" cellpadding=5 class="mb-4">
                    <tr>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    @forelse ($group->pending_users as $usr)
                        <tr>
                            <td>{{ $usr->username }}</td>
                            <td>{{ $usr->email }}</td>
                            <td>
                                <a href="/group/pending/acc/{{ $group->slug }}/{{ $usr->id }}">Accept</a> |
                                <a href="/group/kick/{{ $group->slug }}/{{ $usr->id }}">Decline</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">None</td>
                        </tr>
                    @endforelse
                    </tr>
                </table>
            </div>
        </div>
        <div class="card mb-3 shadow">
            <div class="card-header">{{ __('Member Group') }}</div>
            <div class="card-body">
                <table border="1" cellpadding=5 class="mb-4">
                    <tr>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    @forelse ($group->users as $usr)
                        <tr>
                            <td>{{ $usr->username }}</td>
                            <td>{{ $usr->email }}</td>
                            <td>
                                @if ($group->owners[0]->id == $usr->id)
                                    None
                                @else
                                    <a href="/group/kick/{{ $group->slug }}/{{ $usr->id }}">Kick</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">None</td>
                        </tr>
                    @endforelse
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection

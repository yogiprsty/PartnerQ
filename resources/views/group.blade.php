@extends('layouts.app')
@section('content')
    <div class="row justify-content-center px-4">
        <div class="col-md-3">
            <h5>Sidebar</h5>
            <ul>
                <li><a href="/group/create">create group</a></li>
            </ul>
            <h5>Owned Group</h5>
            <ul>
                @forelse ($user->owned_groups as $group)
                    <li><a href="/{{ $group->slug }}">{{ $group->name }}</a></li>
                @empty
                    <li>No Group</li>
                @endforelse
            </ul>
            <h5>My Group</h5>
            <ul>
                @forelse ($user->my_groups as $group)
                    <li><a href="/{{ $group->slug }}">{{ $group->name }}</a></li>
                @empty
                    <li>No Group</li>
                @endforelse
            </ul>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    {{ $grp->name }}
                    @if ($grp->owners[0]->id == Auth::user()->id)
                        <a href="/group/settings/{{ $grp->slug }}">settings</a>
                    @endif
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <button type="button" id="refresh-button" class="mb-3">Refresh Chat</button>
                    <div id="chat-container" data-slug="{{ $grp->slug }}">
                        <ul id="list-chat">
                            
                        </ul>
                    </div>
                    <div id="send-container">
                        
                            @csrf
                            <input type="hidden" name="group_id" id="group_id" value="{{ $grp->id }}">
                            <input type="text" name="chat_text" id="chat_text" placeholder="type a chat">
                            <button type="button" id="send-button">Send</button>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
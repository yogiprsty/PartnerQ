@extends('layouts.app')
@section('content')
    <div class="">
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
                <div class="border bg-dark rounded p-3" id="chat-container" data-name="{{ $user->username }}" data-slug="{{ $grp->slug }}">
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
@endsection
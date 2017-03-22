@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Join a conversation</h1>

    <div class="row">
        <!-- left main chat area -->
        <div class="col-md-9">
            @include('contact.chat-section')
        </div>

        <!-- right side panel -->
        <div class="col-md-3">
            <!-- staff info here -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    User chat
                </div>
                <div class="panel-body" id="chat-meta">
                    <p>Waiting for connection</p>
                </div>
                <div class="panel-body">
                    <a href="/contact/chat/end/{{ $chatSessionId }}" class="btn btn-danger">End</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Globals from admin interface
var adminMode = true
  , chatMetadata = {
        chatSessionId: {{ $chatSessionId }},
        remoteUser: '{{ $remoteUserName }}',
        user: {
            mode: '{{ $user['mode'] }}',
            display_name: '{{ $user['display_name'] }}'
        }
    }
</script>
<script src="/js/chat.js"></script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chat to a member of staff</h1>

    <div class="row">
        <!-- left main chat area -->
        <div class="col-md-9">
            @include('contact.otherchat')
        </div>

        <!-- right side panel -->
        <div class="col-md-3">
            <!-- staff info here -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Talk to us
                </div>
                <div class="panel-body" id="chat-meta">
                    <p>Waiting for connection</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/js/chat.js"></script>
@endsection

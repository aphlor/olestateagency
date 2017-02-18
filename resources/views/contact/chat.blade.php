@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chat to a member of staff</h1>

    <div class="row">
        <!-- left main chat area -->
        <div class="col-md-9">
            @if ($subject == 'property')
                @include('contact.propertychat')
            @else
                @include('contact.otherchat')
            @endif
        </div>

        <!-- right side panel -->
        <div class="col-md-3">
            <!-- staff info here -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Talk to us
                </div>
                <div class="panel-body">
                    <p>Chat session opened at {{ (new DateTime)->format('d/m/Y H:i') }}</p>

                    <p>You are connected to staff member <strong>Joe Bloggs</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

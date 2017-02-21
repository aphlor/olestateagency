@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Contact us</h1>

    <div class="panel panel-default"><div class="panel-body">
        @if (isset($property))
        <!-- if we're viewing a property, include brief details -->
        <div class="panel panel-primary">
            <div class="panel-heading">Contact regarding property</div>
            <div class="panel-body">
                @if (isset($property))
                    @include('property.listing')
                @endif
            </div>
        </div>
        @endif

        <div class="form-group">
            <form method="post" action="/contact/sendmessage">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ isset($user) ? $user->name : '' }}" />

                <label for="email">Email</label>
                <input type="text" name="email" id="email" class="form-control" value="{{ isset($user) ? $user->email : '' }}" />

                <label for="message">Message</label>
                <textarea class="form-control" name="message" id="message"></textarea>

                <hr />

                <input type="submit" class="btn btn-default" value="Send" />
            </form>
        </div>
    </div></div>
</div>
@endsection

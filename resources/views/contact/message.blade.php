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
                {{ csrf_field() }}

                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ isset($user) ? $user->name : '' }}" />

                <label for="email">Email</label>
                <input type="text" name="email" id="email" class="form-control" value="{{ isset($user) ? $user->email : '' }}" />

                <label for="message">Message</label>
                @if (isset($property))
                    <textarea class="form-control" name="message" id="message"> Hello,

I am interested in arranging a viewing for property (ID# {{ $property->id }}) at:
    {{ $property->address_line_1 }}, {{ $property->address_line_2 }}, {{ $property->town }}, {{ $property->postcode }}

Please contact me on my telephone number</textarea>
                @else
                    <textarea class="form-control" name="message" id="message"></textarea>
                @endif

                <hr />

                <input type="submit" class="btn btn-success" value="Send" />
            </form>
        </div>
    </div></div>
</div>

@if (isset($property))
    <script>
    $(document).ready(function () {
        $("#message").focus()
        $("#message").val($("#message").val() + ' ')
    })
    </script>
@endif
@endsection

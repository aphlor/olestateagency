@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Contact us</h1>

    <div class="panel panel-default"><div class="panel-body">
        @if ($subject == 'property')
        <!-- if we're viewing a property, include brief details -->
        <div class="panel panel-primary">
            <div class="panel-heading">You are discussing property</div>
            <div class="panel-body">
                @if (isset($property))
                    @include('property.listing')
                @endif
            </div>
        </div>
        @endif

        <div class="form-group">
            <form>
                <label for="name">Name</label>
                <input type="text" class="form-control"
            </form>
        </div>
    </div></div>
</div>
@endsection

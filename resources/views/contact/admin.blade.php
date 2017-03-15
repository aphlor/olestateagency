@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chat sessions</h1>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>Here you can manage chat sessions.</p>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Calling user</th>
                            <th>Accepting user</th>
                            <th>Time started</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($sessions as $session)
                            <tr>
                                <td>{{ ucfirst($session['subject']) }}</td>
                                <td>{{ is_string($session['user']) ? $session['user'] : $session['user']->name }}</td>
                                <td>
                                    @if (isset($session['adminUser']))
                                        {{ $session['adminUser']->name }}
                                    @else
                                        <em>Awaiting answer</em>
                                    @endif
                                </td>
                                <td>{{ $session['time'] }}</td>
                                <td>
                                    @if (!isset($session['adminUser']))
                                        <a href="/contact/chat/join/{{ $session['id'] }}" class="btn btn-success">Join</a>
                                    @endif
                                </td>
                                <td>
                                    <a href="/contact/chat/end/{{ $session['id'] }}" class="btn btn-danger">Close conversation</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

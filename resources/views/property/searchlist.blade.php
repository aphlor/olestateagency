@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Saved searches</h1>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>You can view searches you have saved.</p>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Search name</th>
                            <th>Terms</th>
                            <th>Date saved</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($searches) === 0)
                            <tr>
                                <td colspan="4"><em>You haven't saved any searches!</em></td>
                            </tr>
                        @endif
                        @foreach ($searches as $search)
                            <tr>
                                <td>{{ $search['name'] }}</td>
                                <td>{{ $search['terms'] }}</td>
                                <td>{{ $search['dateSaved']}}</td>
                                <td>
                                    <a href="/properties/restore/{{ $search['id'] }}" class="btn btn-success">View search</a>
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

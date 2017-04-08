@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">User management</div>
                <div class="panel-body">
                    <p>From here, you can manage user permissions and send password reset requests.</p>

                    <div class="form-group">
                        {{-- <div class="input-group">
                            <input type="text" class="form-control" id="user-filter" placeholder="Enter part of a user email address here to filter" autofocus />
                            <span class="input-group-btn">
                                <button class="btn btn-success">Filter</button>
                            </span>
                        </div> --}}
                    </div>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email address</th>
                            <th>Account type</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div class="form-group">
                                        @if (Auth::user()->id != $user->id)
                                            <div class="input-group">
                                                <select class="form-control">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}"
                                                            {{ $user->role->id === $role->id ? ' selected' : '' }}
                                                         >
                                                            {{ $role->role_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-info">Update role</button>
                                                </span>
                                            </div>
                                        @else
                                            @foreach ($roles as $role)
                                                @if ($user->role->id === $role->id)
                                                    {{ $role->role_name }}
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        @if (Auth::user()->id != $user->id)
                                            <a href="/admin/resetPassword/{{ $user->id }}" class="btn btn-primary">Send password reset</a>
                                            @if ($user->trashed())
                                                <a href="/admin/activateuser/{{ $user->id }}" class="btn btn-success">Activate</a>
                                            @else
                                                <a href="/admin/deactivateuser/{{ $user->id }}" class="btn btn-danger">Deactivate</a>
                                            @endif
                                        @else
                                            <em>Current user; Cannot manage</em>
                                        @endif
                                    </div>
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

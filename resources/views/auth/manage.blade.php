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
                        <div class="input-group">
                            <input type="text" class="form-control" id="user-filter" placeholder="Enter part of a user email address here to filter" autofocus />
                            <span class="input-group-btn">
                                <button class="btn btn-success">Filter</button>
                            </span>
                        </div>
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
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <button class="btn btn-default">Send password reset</button>
                                        <button class="btn btn-danger">{{ empty($user->deleted) ? 'Deactivate' : 'Activate' }}</button>
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

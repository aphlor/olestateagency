@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Content management</div>
                <div class="panel-body">
                    <p>Manage your content pages. Alternatively, <a href="/content/create">create a new page</a>.</p>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" id="user-filter" placeholder="Enter part of a page title to filter the page list" autofocus />
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
                            <th>Title</th>
                            <th>Path</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pages as $page)
                            <tr>
                                <td>{{ $page->id }}</td>
                                <td>{{ $page->title }}</td>
                                <td>/content/view/{{ $page->path }}</td>
                                <td>
                                    <div class="form-group">
                                        <a href="/content/view/{{ $page->path }}" class="btn btn-default">View</a>
                                        <a href="/content/create/{{ $page->id }}" class="btn btn-info">Edit</a>
                                        <button class="btn btn-danger">Delete page</button>
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

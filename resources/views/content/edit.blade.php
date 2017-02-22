@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage content</h1>

    <form method="post" action="/content/create">
        {{ csrf_field() }}
        @if (isset($pageId) && !empty($pageId))
            <input type="hidden" name="pageId" value="{{ $pageId }}" />
        @endif
        <div class="panel panel-default"><div class="panel-body">
            <div class="form-group">
                <form method="post" action="/content/create">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" value="{{ $title }}" placeholder="Enter page title here" />

                    <label for="page">Body</label>
                    <textarea class="form-control" id="editor-body" name="body">{{ $body }}</textarea>

                    <hr />

                    <div class="form-group">
                        <label for="pagePath">Address path section (prefixed with '/content/view/' automatically)</label>
                        <div class="input-group">
                            <input type="text" id="pagePath" name="pagePath" value="{{ $pagePath }}" class="form-control" placeholder="e.g. removals_information" />
                            <span class="input-group-btn">
                                <input type="submit" class="btn btn-success" name="save" value="{{ isset($pageId) && !empty($pageId) ? 'Update' : 'Save' }}" />
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div></div>
    </form>
</div>

<script src="{{ asset('js/simplemde.min.js') }}"></script>
<script>
var simplemde = new SimpleMDE({
    element: $('#editor-body')[0]
})
</script>
@endsection

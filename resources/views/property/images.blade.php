@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Upload images for property {{ $propertyId }}</h1>

    <p><a href="/property/{{ $propertyId }}">Click here</a> to go back to the property.</p>

    <form action="/property/images/{{ $propertyId }}" class="dropzone" id="img-dropzone">
        {{ csrf_field() }}
        <div class="dz-message">
            <p>Drag images here to upload, or click here if your browser doesn't respond to drag-and-drop.</p>
        </div>
    </form>
</div>

<script src="{{ asset('js/dropzone.js') }}"></script>
<script>
Dropzone.options.imgDropzone = {
    acceptedFiles: 'image/jpeg'
}
</script>
@endsection

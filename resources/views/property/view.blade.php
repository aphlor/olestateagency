@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $property->title }}</h1>
    <h3>{{ $address }}</h3>

    <div class="row">
        <div class="col-md-3 list-image-area">
            <div class="row">
                @if (count($property->propertyImage))
                    <a href="{{ asset('img/' . $property->propertyImage->first()->image_filename) }}" data-lightbox="property-images">
                        <img src="{{ asset('img/' . $property->propertyImage->first()->image_filename) }}" class="list-propertyimage" alt="house" />
                    </a>
                @else
                    <p><em>No images yet</em></p>
                @endif
            </div>
            <hr/>
            @foreach ($images as $imageRow)
                <div class="row">
                    @foreach ($imageRow as $pos => $image)
                        <a href="{{ asset('img/' . $image->image_filename) }}" data-lightbox="property-images">
                            <img src="{{ asset('img/' . $image->image_filename) }}" class="list-imageicon" alt="house" />
                        </a>
                        @if ($pos < 2)
                            <span class="twopspacer"></span>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
        <div class="col-md-6">
            {{-- short property description for search listings (n.b. preformatted html, so verbatim) --}}
            {!! $property->description !!}

            <p><h4 class="list-price">{{ $property->priceFormat->display_text }}: &pound;{{ number_format($property->price) }}</h4></p>
        </div>
        <div class="col-md-3 view-buttons">
            <div class="row">
                <a href="/contact/message/{{ $property->id }}" class="btn btn-info">Request a viewing</a>
            </div>
            @if (Auth::check())
                <div class="row">
                    @if ($isSaved)
                        <a href="/property/forget/{{ $property->id }}" id="btn-remove" class="btn btn-danger">Remove from &quot;My properties&quot;</a>
                    @else
                        <a href="/property/save/{{ $property->id }}" id="btn-save" class="btn btn-success">Save to &quot;My properties&quot;</a>
                    @endif
                </div>
            @endif
            <div class="row">
                <a href="/contact/chat/property/{{ $property->id }}" class="btn btn-primary">Chat to an agent</a>
            </div>
            @if (Gate::allows('can-manage-properties'))
                <div class="row">
                    <p>Admin features:</p>
                    <a href="/property/images/{{ $property->id }}" class="btn btn-warning">Upload photos</a>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="{{ asset('js/lightbox.min.js') }}"></script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $property->title }}</h1>
    <h3>{{ $address }}</h3>

    <div class="row">
        <div class="col-md-3 list-image-area">
            <div class="row"><img src="{{ asset('img/property-images/' . $property->propertyImage->first()->image_filename) }}" class="list-propertyimage" alt="house" /></div>
            <hr/>
            @foreach ($images as $imageRow)
                <div class="row">
                    @foreach ($imageRow as $pos => $image)
                        <img src="{{ asset('img/property-images/' . $image->image_filename) }}" class="list-imageicon" alt="house" />
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
                <a href="/contact/mail/property/{{ $property->id }}" class="btn btn-default">Request a viewing</a>
            </div>
            @if (Auth::check())
                <div class="row">
                    @if ($isSaved)
                        <a href="/property/forget/{{ $property->id }}" class="btn btn-danger">Remove from &quot;My properties&quot;</a>
                    @else
                        <a href="/property/save/{{ $property->id }}" class="btn btn-success">Save to &quot;My properties&quot;</a>
                    @endif
                </div>
            @endif
            <div class="row">
                <a href="/contact/chat/property/{{ $property->id }}" class="btn btn-default">Chat to an agent</a>
            </div>
        </div>
    </div>
</div>
@endsection

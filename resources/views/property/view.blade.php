@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $property->title }}</h1>

    <div class="row">
        <div class="col-md-3 list-image-area">
            <div class="row"><img src="{{ asset('img/property-images/' . $property->propertyImage->first()->image_filename) }}" class="list-propertyimage" alt="house" /></div>
            <hr/>
            @foreach ($images as $imageRow)
            <div class="row">
                @foreach ($imageRow as $image)
                <img src="{{ asset('img/property-images/' . $image->image_filename) }}" class="list-imageicon" alt="house" />
                @endforeach
            </div>
            @endforeach
        </div>
        <div class="col-md-9">
            {{-- short property description for search listings (n.b. preformatted html, so verbatim) --}}
            {!! $property->description !!}

            <p><h4 class="list-price">{{ $property->priceFormat->display_text }}: &pound;{{ number_format($property->price) }}</h4></p>
        </div>
    </div>
</div>
@endsection

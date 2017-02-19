@if (count($featuredProperties))
<div class="jumbotron">
    <h3>Featured properties:</h3>

    @foreach ($featuredProperties as $featuredProperty)
    <a href="/property/{{ $featuredProperty->property->id }}" class="property-link"><div class="row feature-property">
        <div class="col-md-3">
            <img src="{{ asset('img/property-images/' . $featuredProperty->property->propertyImage->first()->image_filename) }}" class="list-propertyimage" alt="house" />
        </div>
        <div class="col-md-9">
            <h4>{{ $featuredProperty->property->title }}</h4>

            {{-- short property description for search listings (n.b. preformatted html, so verbatim) --}}
            {!! $featuredProperty->property->short_description !!}

            <p><h4 class="list-price">{{ $featuredProperty->property->priceFormat->display_text }}: &pound;{{ number_format($featuredProperty->property->price) }}</h4></p>
        </div>
    </div></a>
    @endforeach
</div>
@endif

@extends('layouts.app')

@section('content')
<div class="container">
    <!-- property listings -->
    <div class="row">
        <div class="col-md-9">
            <!-- featured property -->
            @include('property.featured')

            <!-- property list -->
            @foreach ($properties as $property)
                @include('property.listing')
            @endforeach
        </div>

        <!-- sidenav -->
        <div class="col-md-3">
            <h4>Filter your results</h4>
            <form>
                <div class="form-group">
                    <label for="minPrice">Minimum price</label>
                    <input type="number" class="form-control" id="minPrice" placeholder="e.g. 100,000"/>
                </div>
                <div class="form-group">
                    <label for="maxPrice">Maximum price</label>
                    <input type="number" class="form-control" id="maxPrice" placeholder="e.g. 500,000"/>
                </div>
                <div class="form-group">
                    <label for="bedrooms">Number of bedrooms</label>
                    <select class="form-control" id="bedrooms">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6+">6+</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="keywords">Keywords</label>
                    <input type="text" class="form-control" id="keywords" placeholder="e.g. garage, conservatory"/>
                </div>
                <button type="submit" class="btn btn-default">Update results</button>
                <input type="reset" class="btn" value="Reset"/>
            </form>
        </div>
    </div>
</div>
@endsection

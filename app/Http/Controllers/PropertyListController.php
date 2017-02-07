<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyStatus;
use App\Models\FeaturedProperty;

class PropertyListController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $featuredProperties = FeaturedProperty::all();
        $properties = Property::all();

        return view('property.index', [
            'featuredProperties' => $featuredProperties,
            'properties' => $properties,
        ]);
    }
}

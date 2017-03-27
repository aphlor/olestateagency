<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyStatus;
use App\Models\FeaturedProperty;

class PropertyListController extends Controller
{
    /** @var array Handling number of bedrooms */
    private static $bedrooms = [
        'any' => '',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6+' => '6+',
    ];

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // default values for the filters
        $filters = [
            'minPrice' => $request->input('minPrice', null),
            'maxPrice' => $request->input('maxPrice', null),
            'bedrooms' => $request->input('bedrooms', null),
            'keywords' => array_filter(preg_split('/[\s,;\.]+/', $request->input('keywords', '')), function ($item) {
                if (!empty($item)) {
                    return true;
                }
            }),
        ];

        // we need these models; set the classes up now before we look at filters
        $featuredProperties = new FeaturedProperty;
        $properties = new Property;

        $featuredProperties = $featuredProperties->all();

        // $featuredProperties = DB::table('featured_properties')
        //     ->join('properties', 'properties.id', 'featured_properties.property_id')
        //     ->join('property_statuses', 'property_statuses.id', 'properties.property_status_id')
        //     ->where('property_statuses.marketable', '=', 1)
        //     ->get();

        $properties = $properties->whereNotIn('id', function ($q) {
            $q->select('property_id')
                ->from('featured_properties');
        })->get();

        // perform filtering
        if ($filters['minPrice'] !== null) {
            $featuredProperties = $featuredProperties->reject(function ($featuredProperty) use ($filters) {
                return $featuredProperty->property->price < $filters['minPrice'];
            });

            $properties = $properties->reject(function ($property) use ($filters) {
                return $property->price < $filters['minPrice'];
            });
        }

        if ($filters['maxPrice'] !== null) {
            $featuredProperties = $featuredProperties->reject(function ($featuredProperty) use ($filters) {
                return $featuredProperty->property->price > $filters['maxPrice'];
            });

            $properties = $properties->reject(function ($property) use ($filters) {
                return $property->price > $filters['maxPrice'];
            });
        }

        if ($filters['bedrooms'] !== null) {
            // a little functional programming here...
            $bedTest = function ($bedrooms) use ($filters) {
                if ($filters['bedrooms'] === '6+') {
                    return $bedrooms < 6;
                }
                return $bedrooms != $filters['bedrooms'];
            };

            $featuredProperties = $featuredProperties->reject(function ($featuredProperty) use ($filters, $bedTest) {
                return $bedTest($featuredProperty->property->bedrooms);
            });

            $properties = $properties->reject(function ($property) use ($filters, $bedTest) {
                return $bedTest($property->bedrooms);
            });
        }

        return view('property.index', [
            'bedrooms' => self::$bedrooms,
            'totalProperties' => count($featuredProperties) + count($properties),
            'featuredProperties' => $featuredProperties,
            'properties' => $properties,
        ]);
    }
}

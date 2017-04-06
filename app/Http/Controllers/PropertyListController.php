<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyStatus;
use App\Models\FeaturedProperty;
use App\Models\SavedSearch;
use App\Models\SavedProperty;

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
     * @param array   $savedFilters Saved filters to restore
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, array $savedFilters = [])
    {
        // default values for the filters
        if (empty($savedFilters)) {
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
        } else {
            $filters = $savedFilters;
        }


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

        if (!empty($filters['keywords'])) {
            $keywordTest = function ($title, $subtitle, $description, $shortDescription) use ($filters) {
                // prepare a word count list
                $words = $filters['keywords'];
                array_walk($words, function (&$item) {
                    $item = preg_quote($item);
                });
                $words = array_flip($words);
                array_walk($words, function (&$item) {
                    $item = 0;
                });

                // perform the actual search
                foreach ($words as $word => $count) {
                    $titleCount = (int) preg_match('/\b' . $word . '\b/i', $title);
                    $subtitleCount = (int) preg_match('/\b' . $word . '\b/i', $subtitle);
                    $descriptionCount = (int) preg_match('/\b' . $word . '\b/i', $description);
                    $shortDescriptionCount = (int) preg_match('/\b' . $word . '\b/i', $shortDescription);

                    $words[$word] = $titleCount + $subtitleCount + $descriptionCount + $shortDescriptionCount;
                }

                // return 'false' for anything which wasn't matched
                foreach ($words as $count) {
                    if ($count == 0) {
                        return true;
                    }
                }

                // we're still here, so we must have matched
                return false;
            };

            $featuredProperties = $featuredProperties->reject(function ($featuredProperty) use ($filters, $keywordTest) {
                return $keywordTest(
                    $featuredProperty->property->title,
                    $featuredProperty->property->subtitle,
                    strip_tags($featuredProperty->property->description),
                    strip_tags($featuredProperty->property->short_description)
                );
            });

            $properties = $properties->reject(function ($property) use ($filters, $keywordTest) {
                return $keywordTest(
                    $property->title,
                    $property->subtitle,
                    strip_tags($property->description),
                    strip_tags($property->short_description)
                );
            });
        }

        return view('property.index', [
            'bedrooms' => self::$bedrooms,
            'totalProperties' => count($featuredProperties) + count($properties),
            'featuredProperties' => $featuredProperties,
            'properties' => $properties,
            'filters' => json_encode($filters),
            'filterData' => $filters,
        ]);
    }

    /**
     * Save a search for later retrieval.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function saveSearch(Request $request)
    {
        if (!Auth::check()) {
            abort(500, 'User not logged in');
        }

        SavedSearch::create([
            'user_id' => Auth::user()->id,
            'name' => empty($request->input('searchName'))
                ? 'Unnamed search'
                : $request->input('searchName'),
            'filter_data' => $request->input('filters', ''),
        ]);

        return $this->index($request, json_decode($request->input('filters', '{}'), true));
    }

    /**
     * Retrieve and display a search
     *
     * @param Request $request
     * @param int     $id       Saved search ID
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, int $id)
    {
        if (!Auth::check()) {
            abort(500, 'User not logged in');
        }

        $search = SavedSearch::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->first();

        return $this->index($request, json_decode($search['filter_data'], true));
    }

    /**
     * Make a list of searches
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function listSearches(Request $request)
    {
        if (!Auth::check()) {
            abort(500, 'User not logged in');
        }

        $searches = SavedSearch::where('user_id', Auth::user()->id)->get();

        $formattedSearches = [];
        foreach ($searches as $search) {
            $terms = [];

            $unpacked = json_decode($search->filter_data, true);
            if (isset($unpacked['minPrice']) && !empty($unpacked['minPrice'])) {
                $terms[] = 'Minimum price £' . $unpacked['minPrice'];
            }
            if (isset($unpacked['maxPrice']) && !empty($unpacked['maxPrice'])) {
                $terms[] = 'Maximum price £' . $unpacked['maxPrice'];
            }
            if (isset($unpacked['bedrooms']) && !empty($unpacked['bedrooms'])) {
                $terms[] = 'Bedrooms: ' . $unpacked['bedrooms'];
            }
            if (isset($unpacked['keywords']) && !empty($unpacked['keywords'])) {
                $terms[] = 'Keywords: ' . join(', ', $unpacked['keywords']);
            }

            $formattedSearches[] = [
                'id' => $search->id,
                'name' => $search->name,
                'terms' => join(', ', $terms),
                'dateSaved' => $search->created_at,
            ];
        }

        return view('property.searchlist', [
            'searches' => $formattedSearches,
        ]);
    }
}

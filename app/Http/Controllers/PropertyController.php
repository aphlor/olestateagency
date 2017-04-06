<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PriceFormat;
use App\Models\SavedProperty;

class PropertyController extends Controller
{
    /**
     * Show the requested property.
     *
     * @param Request $request  The request object
     * @param int     $id       Property ID to view
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, int $id)
    {
        $property = Property::find($id);
        $images = PropertyImage::where('property_id', $id)->get();

        $isSaved = false;
        if (Auth::check()) {
            $savedProperty = SavedProperty::where('user_id', Auth::user()->id)
                ->where('property_id', $id)
                ->get();

            if (count($savedProperty) > 0) {
                $isSaved = true;
            }
        }

        $address = implode(
            ', ',
            array_map(
                function ($i) {
                    if (isset($i) && !empty(trim($i))) {
                        return $i;
                    }
                },
                [
                    $property->address_line_1,
                    $property->address_line_2,
                    $property->town,
                    $property->county,
                    $property->postcode,
                ]
            )
        );

        $imagesSplitByThree = [];
        $accumulator = [];
        foreach ($images as $image) {
            if (count($accumulator) === 3) {
                $imagesSplitByThree[] = $accumulator;
                $accumulator = [];
            }
            $accumulator[] = $image;
        }
        if (count($accumulator) > 0) {
            $imagesSplitByThree[] = $accumulator;
        }

        return view('property.view', [
            'property' => $property,
            'address' => $address,
            'images' => $imagesSplitByThree,
            'isSaved' => $isSaved,
        ]);
    }

    /**
     * Save the requested property to a list
     *
     * @param Request $request  The request object
     * @param int     $id       Property ID to save
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request, int $id)
    {
        if (!Auth::check()) {
            abort(403, 'Not logged in');
        }

        SavedProperty::create([
            'user_id' => Auth::user()->id,
            'property_id' => $id,
        ]);

        // run the view facility now we're saved
        return $this->index($request, $id);
    }

    /**
     * Remove the requested property from the save list
     *
     * @param Request $request  The request object
     * @param int     $id       Property ID to save
     * @return \Illuminate\Http\Response
     */
    public function forget(Request $request, int $id)
    {
        if (!Auth::check()) {
            abort(403, 'Not logged in');
        }

        SavedProperty::where('user_id', Auth::user()->id)
            ->where('property_id', $id)
            ->delete();

        // run the view facility now we're saved
        return $this->index($request, $id);
    }

    /**
     * Create a new property
     *
     * @param Request $request  The request object
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (Gate::denies('can-manage-properties')) {
            abort(403, 'Unauthorized action');
        }

        return view('property.add', [
            'propertyTitle' => '',
            'address1' => '',
            'address2' => '',
            'town' => '',
            'county' => '',
            'postcode' => '',
            'price' => '',
            'priceFormat' => '',
            'priceFormats' => PriceFormat::all(),
            'shortDescription' => '',
            'description' => '',
        ]);
    }

    /**
     * Edit a property
     *
     * @param Request $request    The request object
     * @param int     $propertyId The ID of the property we're editing
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, int $propertyId)
    {
        if (Gate::denies('can-manage-properties')) {
            abort(403, 'Unauthorized action');
        }

        $property = Property::find($propertyId);

        $formParameters = [
            'propertyTitle' => $request->input('propertyTitle', $property->title),
            'address1' => $request->input('address1', $property->address_line_1),
            'address2' => $request->input('address2', $property->address_line_2),
            'town' => $request->input('town', $property->town),
            'county' => $request->input('county', $property->county),
            'postcode' => $request->input('postcode', $property->postcode),
            'price' => $request->input('price', $property->price),
            'priceFormat' => $request->input('priceFormat', $property->priceFormat),
            'priceFormats' => PriceFormat::all(),
            'shortDescription' => $request->input('shortDescription', $property->short_description),
            'description' => $request->input('description', $property->description),
        ];

        return view('property.add', $formParameters);
    }
}

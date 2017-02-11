<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Property;
use App\Models\PropertyImage;

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
            'images' => $imagesSplitByThree,
        ]);
    }
}

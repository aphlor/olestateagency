<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Property;

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // make authentication mandatory?
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param int       $propertyId An optional property ID as a subject
     * @return \Illuminate\Http\Response
     */
    public function index(int $propertyId = 0)
    {
        $params = [];

        if ($propertyId != 0) {
            $params['property'] = Property::find($propertyId);
        }

        if (Auth::check()) {
            $params['user'] = Auth::user();
        }

        // until we decide on a dashboard layout, go straight to properties
        return view('contact.message', $params);
    }
}

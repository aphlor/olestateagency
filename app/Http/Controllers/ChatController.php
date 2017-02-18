<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class ChatController extends Controller
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
     * @param Request   $request    The request object
     * @param string    $subject    Topic matter of discussion
     * @param int       $key        An optional key
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, string $subject, int $key = 0)
    {
        $params = ['subject' => $subject];

        if (($subject === 'property') && isset($key)) {
            $params['property'] = Property::find($key);
        }

        // until we decide on a dashboard layout, go straight to properties
        return view('contact.chat', $params);
    }
}

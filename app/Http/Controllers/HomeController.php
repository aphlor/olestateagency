<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Content;

class HomeController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $content = Content::where('path', 'home')->first();

        // check if there's a content page for this. if not, go straight to property list
        if ($content === null) {
            // until we decide on a dashboard layout, go straight to properties
            return redirect()->route('properties');
        }

        // great, there's a content page called "home". let's go to it.
        return redirect()->route('viewcontent', 'home');
    }
}

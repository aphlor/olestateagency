<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Mail\Contact;
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
        $params = [
            'user' => Auth::check() ? Auth::user() : null
        ];

        if ($propertyId != 0) {
            $params['property'] = Property::find($propertyId);
        }

        // until we decide on a dashboard layout, go straight to properties
        return view('contact.message', $params);
    }

    /**
     * Send a contact message
     *
     * @param Request   $request    The request object
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        if (empty(env('MAIL_WEBSITE_RECIPIENT'))) {
            abort(500, 'Missing configuration in environment: MAIL_WEBSITE_RECIPIENT');
        }

        Mail::to(env('MAIL_WEBSITE_RECIPIENT'))
            ->send(new Contact([
                'senderName' => $request->input('name', '<empty>'),
                'senderEmail' => $request->input('email', '<empty>'),
                'body' => strip_tags(html_entity_decode($request->input('message', ''))),
            ]));

        return view('contact.sent');
    }
}

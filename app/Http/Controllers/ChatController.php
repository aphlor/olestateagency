<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Property;
use App\Models\ChatSession;

class ChatController extends Controller
{
    /** @var valid subjects */
    private static $subjects = ['other', 'property'];

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

    /**
     * Setup a conversation.
     *
     * @param Request   $request    The request object
     * @return \Illuminate\Http\Response
     */
    public function setup(Request $request)
    {
        // default parameters
        $parameters = [
            'user' => [
                'mode' => 'guest',
                'display_name' => 'Guest User',
            ],
        ];

        // check for a logged in user and use those details
        if (Auth::check()) {
            // we're authorised; obtain the user name for display purposes
            $parameters['user'] = [
                'mode' => 'authorised',
                'display_name' => Auth::user()->name,
            ];
        }

        // check for a valid subject
        $subject = $request->input('subject', 'other');
        if (!in_array($subject, self::$subjects)) {
            abort(500, 'Invalid subject (use ' . json_encode(self::$subjects) . ')');
        }

        $parameters['subject'] = $subject;

        // now initialise a new chat record and send back the key
        $chatSession = ChatSession::create([
            'initiating_user_id' => Auth::check() ? Auth::user()->id : null,
            'subject' => $subject,
            'completed' => 0,
        ]);

        $parameters['chat_session_id'] = $chatSession->id;

        return response()->json($parameters);
    }
}

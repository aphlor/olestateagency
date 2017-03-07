<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Property;
use App\Models\ChatSession;
use App\Models\ChatMessage;

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

    private static function initiator(int $chatSessionId, User $user = null)
    {
        $chatSession = ChatSession::find($chatSessionId);

        if (($user !== null) && ($chatSession->initiating_user_id == $user->id)) {
            // we're logged in and the initiating user
            return true;
        }

        if (($user === null) && !isset($chatSession->initiating_user_id)) {
            // we're not logged in and the chat session is anonymous (i.e. we're the initiator)
            return true;
        }

        // we didn't initiate the chat session
        return false;
    }

    /**
     * Send a message to a conversation.
     *
     * @param Request   $request    The request object
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        $message = ChatMessage::create([
            'chat_session_id' => $request->input('chatSessionId'),
            'message_text' => $request->input('message'),
            'from_initiator' => Auth::check() ?
                self::initiator($request->input('chatSessionId'), Auth::user()) :
                self::initiator($request->input('chatSessionId')),
        ]);

        return response()->json([
            'success' => true,
            'messageId' => $message->id,
        ]);
    }

    /**
     * Poll conversation for updates.
     *
     * @param Request   $request    The request object
     * @return \Illuminate\Http\Response
     */
    public function poll(Request $request)
    {
        $events = ChatMessage::where('chat_session_id', $request->input('chatSessionId'))
            ->where('id', '>', $request->input('checkpoint', 0))
            ->get();

        $chat = ChatSession::find($request->input('chatSessionId'));

        $active = false;
        if (isset($chat->accepting_user_id)
            && ($chat->accepting_user_id !== null)
            && ($chat->completed == 0)
        ) {
            $active = true;
        }

        $strippedEvents = [];
        foreach ($events as $event) {
            $strippedEvents[] = [
                'id' => $event->id,
                'message_text' => $event->message_text,
                'from_initiator' => $event->from_initiator,
            ];
        }

        return response()->json([
            'success' => true,
            'active' => $active,
            'participant_id' => $chat->accepting_user_id,
            'participant_name' => $active ? $chat->accepting_user->name : '',
            'events' => $strippedEvents,
        ]);
    }

    /**
     * End a conversation.
     *
     * @param Request   $request    The request object
     * @return \Illuminate\Http\Response
     */
    public function end(Request $request)
    {
        $message = ChatMessage::create([
            'chat_session_id' => $request->input('chatSessionId'),
            'message_text' => $request->input('message'),
            'from_initiator' => Auth::check() ?
                self::initiator($request->input('chatSessionId'), Auth::user()) :
                self::initiator($request->input('chatSessionId')),
        ]);

        $session = ChatSession::find($request->input('chatSessionId'));
        $session->completed = 1;
        $session->save();

        return response()->json([
            'success' => true,
            'messageId' => $message->id,
        ]);
    }
}

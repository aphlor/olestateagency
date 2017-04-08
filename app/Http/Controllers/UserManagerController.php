<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;

class UserManagerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // make authentication mandatory?
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request   $request    The request object
     * @param string    $subject    Topic matter of discussion
     * @param int       $key        An optional key
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Gate::denies('can-manage-accounts')) {
            abort(403, 'Unauthorized action');
        }

        // until we decide on a dashboard layout, go straight to properties
        return view('auth.manage', [
            'users' => User::withTrashed()->get(),
            'roles' => Role::all(),
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @param Request   $request    The request object
     * @param int       $userId     User to reset
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request, int $userId)
    {
        if (Gate::denies('can-manage-accounts')) {
            abort(403, 'Unauthorized action');
        }

        $user = User::find($userId);

        $response = Password::sendResetLink(['email' => $user->email]);

        return $this->index($request);
    }

    /**
     * Deactivate a user
     *
     * @param Request   $request    The request object
     * @param int       $userId     User to reset
     * @return \Illuminate\Http\Response
     */
    public function deactivate(Request $request, int $userId)
    {
        if (Gate::denies('can-manage-accounts')) {
            abort(403, 'Unauthorized action');
        }

        $user = User::find($userId);
        $user->delete();

        return $this->index($request);
    }

    /**
     * Activate a user
     *
     * @param Request   $request    The request object
     * @param int       $userId     User to reset
     * @return \Illuminate\Http\Response
     */
    public function activate(Request $request, int $userId)
    {
        if (Gate::denies('can-manage-accounts')) {
            abort(403, 'Unauthorized action');
        }

        $user = User::withTrashed()
            ->find($userId);
        $user->restore();

        return $this->index($request);
    }
}

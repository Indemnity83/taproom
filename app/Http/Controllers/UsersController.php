<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class UsersController extends Controller
{

    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Users tokens (api-keys)
     */
    public function tokens()
    {
        $tokens = Auth::user()->tokens;

        return view('settings.tokens', compact('tokens'));
    }
}

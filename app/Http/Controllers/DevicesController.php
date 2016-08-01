<?php

namespace App\Http\Controllers;

use App\Token;
use Illuminate\Http\Request;

class DevicesController extends Controller
{
    /**
     * DevicesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for pairing a new device.
     */
    public function createPair()
    {
        return view('devices.pair');
    }

    /**
     * Validate the device pairing token.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePair(Request $request)
    {
        $this->validate($request, [
            'token' => 'required|in:'.Token::tokens(),
        ]);

        $token = Token::findOrFail($request['token']);
        $token->validate(auth()->user()->id);

        return redirect('/')->with('status', 'Device Validated!');
    }
}

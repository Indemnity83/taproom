<?php

namespace App\Http\Controllers;

use App\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class DevicesController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function startPairing(Request $request)
    {
        $name = $request->input('name', 'Unknown Device');
        $token = Token::generate($name);

        $response = [
            'name' => $token->name,
            'code' => $token->token,
            'linked' => (bool)$token->is_validated
        ];

        return Response::json([
            'object' => $response,
            'meta' => [
                'result' => 'ok'
            ]
        ]);
    }

    /**
     * @param Token $token
     * @return mixed
     */
    public function checkPairing(Token $token)
    {
        $response = [
            'name' => $token->name,
            'code' => $token->token,
            'linked' => (bool)$token->is_validated
        ];

        if ($token->is_validated) {
            // Get API Key
            // Add API key to response
            $response['api_key'] = 'hpuT05132M1Nf220FOdwexces01XfdBv';
            // Invalidate token
        }

        return Response::json([
            'object' => $response,
            'meta' => [
                'result' => 'ok'
            ]
        ]);
    }

}

<?php

namespace App\Http\Controllers\Api;

use App\Serializer\KegbotSerializer;
use App\Token;
use App\Transformers\TokenTransformer;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use Illuminate\Http\Request;

class DeviceLinkController extends ApiGuardController
{

    protected $apiMethods = [
        'startPairing' => [
            'keyAuthentication' => false
        ],
        'checkPairing' => [
            'keyAuthentication' => false
        ],
    ];

    /**
     * Generate a pairing token
     *
     * @param Request $request
     * @return mixed
     */
    public function startPairing(Request $request)
    {
        $name = $request->input('name', 'Unknown Device');
        $token = Token::generate($name);

        $this->response->getManager()->setSerializer(new KegbotSerializer());

        return $this->response->withItem($token, new TokenTransformer);
    }

    /**
     * Show status of pairing token
     *
     * @param Token $token
     * @return mixed
     */
    public function checkPairing(Token $token)
    {
        if ($token->is_validated) {
            $token->expire();
        }

        $this->response->getManager()->setSerializer(new KegbotSerializer());

        return $this->response->withItem($token, new TokenTransformer);
    }

}

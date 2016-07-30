<?php

namespace App\Transformers;

use App\Token;
use League\Fractal\TransformerAbstract;

class TokenTransformer extends TransformerAbstract
{

    public function transform(Token $token)
    {
        return [
            'name'    => $token->name,
            'code'    => $token->token,
            'linked'  => (bool)$token->is_validated,
            'api_key' => $token->api_key_id ? $token->apiKey->key : '',
            'links'   => [
                'rel' => 'self',
                'uri' => '/api/v1/devices/link/status/' . $token->token
            ]
        ];
    }
}
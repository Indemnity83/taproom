<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class DevicePairingTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Protocol:.
     *
     * Client initiates a new pairing session by POSTing to `/api/v1/devices/link`.
     *
     * Server generates a new opaque and unguessable short-lived pairing token and
     * returns it to the client.
     *
     * Client displays the pairing token on its screen, and continuously polls its
     * status via `/api/v1/devices/status/<token>`
     *
     * User logs in to the web interface and confirms the request by entering the
     * same access token into a form, causing the token to be marked as validated
     *
     * On next subsequent poll of `/api/v1/devices/status/<token>`, the request handler
     * discovers the token has been confirmed, creates a new Device record and ApiKey,
     * and returns the ApiKey.
     */

    /** @test */
    public function client_initiates_pairing_session_and_server_returns_pairing_token()
    {
        // Given a device
        $deviceName = 'Test Device';

        // Where client initiates pairing, and server generates token
        $client = $this->json('POST', '/api/v1/devices/link', ['name' => $deviceName]);
        $token = App\Token::first();

        // Assert the token is returned to the client
        $client->seeJsonStructure([
            'object' => ['name', 'linked', 'code'],
        ]);
        $client->seeJson(['name' => $deviceName]);
        $client->seeJson(['linked' => false]);
        $client->seeJson(['code' => $token->token]);
    }

    /** @test */
    public function client_polls_pairing_status_before_validation()
    {
        // Given an un-validated token exists on the server
        $token = App\Token::generate('Test Device');

        // Where the client polls the token
        $client = $this->json('GET', '/api/v1/devices/link/status/'.$token->token);

        // Assert the token returns status
        $client->seeJsonStructure([
            'object' => ['linked'],
        ]);
        $client->seeJson(['linked' => false]);
    }

    /** @test */
    public function client_polls_expired_pairing_token()
    {
        // Given an token exists on the server, but is expired
        $token = App\Token::generate('Test Device');
        $token->expire();

        // Where the client polls the token
        $client = $this->json('GET', '/api/v1/devices/link/status/'.$token->token);

        // Assert the query returns a model not found result
        $client->seeJson(['code' => 'NotFoundError']);
    }

    /** @test */
    public function client_polls_pairing_status_after_validation()
    {
        // Given a user validated token exists on the server
        $user = factory(App\User::class)->create();
        $token = App\Token::generate('Test Device');
        $token->validate($user->id);

        // Where the client polls the token
        $client = $this->json('GET', '/api/v1/devices/link/status/'.$token->token);

        // Assert the token returns status and an API key
        $client->seeJsonStructure([
            'object' => ['linked', 'api_key'],
        ]);
        $client->seeJson(['linked' => true]);
        $client->seeJson(['api_key' => $token->apiKey->key]);
    }
}

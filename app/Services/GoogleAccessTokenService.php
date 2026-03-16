<?php

namespace App\Services;

use Google\Client as Google_Client;

class GoogleAccessTokenService
{
    private $scopes = [
        'https://www.googleapis.com/auth/firebase.messaging',
    ];

    public function getAccessToken()
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-service-account.json'));
        $client->setScopes($this->scopes);

        $client->useApplicationDefaultCredentials();

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithAssertion();
        }

        return $client->getAccessToken()['access_token'];
    }
}

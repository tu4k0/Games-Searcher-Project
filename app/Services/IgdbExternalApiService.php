<?php

namespace App\Services;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class IgdbExternalApiService
{

    protected Client|null $client = null;
    public string $access_token;

    public function getClient(): ?Client
    {
        if (is_null($this->client)) {
            $this->client = new Client();
        }

        return $this->client;
    }

    public function getAccessToken() {
        $response = $this->getClient()->request('POST', 'https://id.twitch.tv/oauth2/token', ['form_params' => [
            'client_id' => config('igdb.credentials.client_id'),
            'client_secret' => config('igdb.credentials.client_secret'),
            'grant_type' => config('igdb.credentials.grant_type')]
        ]);
        $responseData = json_decode($response->getBody(), true);
        $this->access_token = $responseData["access_token"];

        return $this->access_token;
    }

    public function getGames(): ResponseInterface
    {
        $response = $this->getClient()->request('POST', 'https://api.igdb.com/v4/games', [
            'headers' => [
            'Client-ID' => config('igdb.credentials.client_id'),
            'Authorization' => 'Bearer ' . $this->access_token
            ],
            'body' => 'fields *;'
        ]);

        return $response;
    }

    public function getGameByName(string $name): ResponseInterface
    {
        $body = sprintf('search "%s"; fields *;', $name);
        $response = $this->getClient()->request('POST', 'https://api.igdb.com/v4/games', [
            'headers' => [
                'Client-ID' => config('igdb.credentials.client_id'),
                'Authorization' => 'Bearer ' . $this->access_token
            ],
            'body' => $body
        ]);

        return $response;
    }
}

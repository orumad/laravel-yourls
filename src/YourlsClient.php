<?php

namespace Orumad\Yourls;

use GuzzleHttp\Client;

class YourlsClient
{
    private $client;
    private $token;

    public function __construct(string $serverUrl, string $token)
    {
        $this->token = $token;

        $this->client = new Client([
            'base_uri' => $serverUrl,
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);
    }

    public function shortUrl(string $url, string $alias = '', string $aliasTitle = ''): string
    {
        $data = [
            'action' => 'shorturl',
            'url' => $url,
        ];

        if (! empty($alias)) {
            $data['keyword'] = $alias;
        }

        if (! empty($aliasTitle)) {
            $data['title'] = $aliasTitle;
        }

        $response = $this->makePostRequest($data);

        if ($response &&
            isset($response->statusCode) && $response->statusCode == 200 &&
            isset($response->shorturl)) {
            return $response->shorturl;
        }

        return '';
    }

    private function makePostRequest(array $data)
    {
        $data['format'] = 'json';
        $data['signature'] = $this->token;

        $response = $this->client->post('/yourls-api.php', [
            'form_params' => $data
        ]);

        return json_decode($response->getBody()->getContents());
    }

}

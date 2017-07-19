<?php

namespace Orumad\Yourls;

class Yourls
{
    private $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function shortUrl (string $url, string $alias = '', string $aliasTitle = ''): string
    {
        return $this->client->shortUrl($url, $alias, $aliasTitle);
    }
}

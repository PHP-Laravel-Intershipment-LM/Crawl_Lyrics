<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class Crawler
{
    private $client = null;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getSourceFromURL(string $urlSong, $params = [])
    {
        $request = $this->client->request('GET', $urlSong, $params);
        $response = $request->getBody();
        return $response->getContents();
    }

}

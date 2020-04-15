<?php

namespace App\Helpers\Crawler;

use GuzzleHttp\Client;

abstract class BaseCrawler
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

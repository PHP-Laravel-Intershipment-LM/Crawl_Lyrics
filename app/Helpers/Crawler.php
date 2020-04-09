<?php

namespace Crawler;

use GuzzleHttp\Client;
use App\Helpers\Crawler\CrawlerZingMp3;
use App\Helpers\Crawler\CrawlerCSN;

abstract class Crawler
{
    private $client = null;

    public function __construct()
    {
        $this->client = new Client();
    }

    protected function getSourceFromURL(string $urlSong, $params = [])
    {
        $request = $this->client->request('GET', $urlSong, $params);
        $response = $request->getBody();
        return $response->getContents();
    }

}

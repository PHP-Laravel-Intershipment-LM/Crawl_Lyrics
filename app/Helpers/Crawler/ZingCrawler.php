<?php

namespace App\Helpers\Crawler;

use App\Helpers\ZingAPI;

class ZingCrawler extends BaseCrawler
{

    private $apiGenerator;

    public function __construct()
    {
        parent::__construct();
        $this->apiGenerator = new ZingAPI();
    }

    /**
     * Crawl info of the song
     * 
     * @param string|null $url
     * @param string|null $wid
     * 
     * @return array
     */
    public function crawlSongInfo(string $wid = null, string $url = null)
    {
        if (null === $wid && null !== $url) {
            $wid = $this->getIdSong($url);
        } else if (null === $wid && null === $url) {
            return [];
        }
        $url = $this->apiGenerator->generateURL(ZingAPI::URL_INFO, $wid);
        return json_decode($this->getSourceFromURL($url), 1);
    }

    /**
     * Get list artists in region
     * 
     * @param string $id of artist's region
     * @param int $start point of crawling
     * @param int @count length of list want crawl
     * 
     * @return array
     */
    public function crawlArtists(string $wid, int $start, int $count)
    {
        $data = [];
        $n_start = $start;
        $n_count = $count < 199 ? $count : 199;
        $run = true; //Flag check run loop
        while ($run && $n_count >= 0) {
            $url = $this->apiGenerator->generateURL(ZingAPI::URL_LIST_ARTISTS, $wid, null, [
                'type'      => 'genre',
                'sort'      => 'listen',
                'start'     => $n_start,
                'count'     => $n_count
            ]);
            $result = json_decode($this->getSourceFromURL($url), 1);
            if (isset($result['data']['items']) && 0 < sizeof($result['data']['items'])) {
                $data = array_merge($data, $result['data']['items']);
                $n_start += $n_count;
                $n_count = (sizeof($data) + $n_count) > $count ? $count - sizeof($data) : $n_count;
            } else {
                $run = false;
            }
        }
        return $data;
    }

    /**
     * Get all song of artist
     * 
     * @param string $id of artist
     * 
     * @return array
     */
    public function crawlArtistSongs(string $wid)
    {
        $data = [];
        $start = 0;
        $count = 199;
        $run = true; //Flag check run loop
        while ($run) {
            $url = $this->apiGenerator->generateURL(ZingAPI::URL_LIST_ARTIST_SONGS, $wid, null, [
                'type'      => 'artist',
                'sort'      => 'hot',
                'start'     => $start,
                'count'     => $count
            ]);
            $result = json_decode($this->getSourceFromURL($url), 1);
            if (isset($result['data']['items']) && 0 < sizeof($result['data']['items'])) {
                $sizeItems = sizeof($result['data']['items']);
                for ($index = 0; $index < $sizeItems; $index++) {
                    if (true == $result['data']['items'][$index]['has_lyric']) {
                        $result['data']['items'][$index]['lyric'] = $this->getLyricSong($result['data']['items'][$index]['id']);
                    } else {
                        $result['data']['items'][$index]['lyric'] = '';
                    }
                }
                $data = array_merge($data ,$result['data']['items']);
                $start += $count;
            } else {
                $run = false;
            }
        }
        return $data;
    }

    /**
     * Get web id of song
     * 
     * @param string|null $url
     * 
     * @return array
     * @return false
     */
    private function getIdSong(string $url = null)
    {
        if ($url == null) return false;
        $source = parent::getSourceFromURL($url);
        $idPattern = '/"url": "https:\/\/zingmp3.vn\/[a-zA-Z0-9-\/]+\/(ZW[a-zA-z0-9]+)\.html.*"/';
        preg_match($idPattern, $source, $matches);
        // Check matches result
        if (sizeof($matches) > 0)
            return $matches[1];
        return false;
    }

    /**
     * Get lyric of the song
     * 
     * @param string|null $url
     * @param string|null $wid
     * 
     * @return array
     */
    public function getLyricSong(string $wid = null, string $url = null)
    {
        if (null === $wid && null !== $url) {
            $wid = $this->getIdSong($url);
        } else if (null === $wid && null === $url) {
            return [];
        }
        $url = $this->apiGenerator->generateURL(ZingAPI::URL_INFO, $wid);
        $result = json_decode($this->getSourceFromURL($url), 1);
        if (0 < sizeof($result['data']['lyrics'])) {
            return $result['data']['lyrics'][0]['content'];
        }
        return null;
    }
}
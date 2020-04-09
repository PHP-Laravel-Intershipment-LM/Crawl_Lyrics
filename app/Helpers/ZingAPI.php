<?php

namespace App\Helpers;

use DateTime;

class ZingAPI
{
    private $baseURL = 'https://zingmp3.vn/api';
    private $secrectKey = '10a01dcf33762d3a204cb96429918ff6';
    private $apiKey = '38e8643fb0dc04e8d65b99994d3dafff';
    private $urls = [
        'URL_INFO'      => '/song/get-song-info',
        'URL_SEARCH'    => '/search/multi',
        'URL_PLAYLIST'  => '/playlist/get-songs',
        'URL_DOWNLOAD'  => '/download/get-streamings'
    ];

    /*
    * Generate full url for task request
    * @param $idSong - id of song
    */
    public function generateDownloadURL($id)
    {
        $queryString = $this->generateQuery([
            'ctime' => $this->getTimestamp(),
            'id'    => $id
        ]);
        $signature = $this->generateSignature($this->urls['URL_DOWNLOAD'], str_replace('&', '', $queryString));
        $result = $this->baseURL.$this->urls['URL_DOWNLOAD'].'?'.$queryString.'&api_key='.$this->apiKey.'&sig='.$signature;
        return $result;
    }

    /*
    * Generate full url for task request
    * @param $idSong - id of playlist
    */
    public function generateGetPlaylistURL($idPlaylist)
    {
        $queryString = $this->generateQuery([
            'ctime' => $this->getTimestamp(),
            'id'    => $idPlaylist
        ]);
        $signature = $this->generateSignature($this->urls['URL_PLAYLIST'], str_replace('&', '', $queryString));
        $result = $this->baseURL.$this->urls['URL_PLAYLIST'].'?'.$queryString.'&api_key='.$this->apiKey.'&sig='.$signature;
        return $result;
    }

    /*
    * Generate full url for task request
    * @param $idSong - id of song
    */
    public function generateGetInfoURL($idSong)
    {
        $queryString = $this->generateQuery([
            'ctime' => $this->getTimestamp(),
            'id'    => $idSong
        ]);
        $signature = $this->generateSignature($this->urls['URL_INFO'], str_replace('&', '', $queryString));
        $result = $this->baseURL.$this->urls['URL_INFO'].'?'.$queryString.'&api_key='.$this->apiKey.'&sig='.$signature;
        return $result;
    }

    /*
    * Generate full url for task request
    * @param $querySearch - text to search
    */
    public function generateSearchURL($querySearch) {
        $timestamp = $this->getTimestamp();
        $signature = $this->generateSignature($this->urls['URL_SEARCH'], $this->generateQuery(['ctime' => $timestamp]));
        $result = $this->baseURL.$this->urls['URL_SEARCH'].'?ctime='.$timestamp.'&q='.$querySearch.'&api_key='.$this->apiKey.'&sig='.$signature;
        return $result;
    }

    /*
    * Generate signature to api
    * @param $query - query string to task, contain ctime and one dynamic param of task
    * @return string - signature of api
    */
    private function generateSignature($url, $query) {
        $hash = hash('sha256', $query);
        $sig = hash_hmac('sha512', $url . $hash, $this->secrectKey);
        return $sig;
    }

    /*
    * Generate query for task
    * @param $data - array contain key - value of parameter want to request
    */
    private function generateQuery($data) {
        return http_build_query($data);
    }

    /*
    * Get system timestamp
    * @return int - current timestamp
    */
    private function getTimestamp() 
    {
        $date = new DateTime();
        return $date->getTimestamp();
    }
}
<?php

namespace API;

class GenerateAPI
{
    private $baseURL = 'https://zingmp3.vn/api';
    private $secrectKey = '10a01dcf33762d3a204cb96429918ff6';
    private $apiKey = '38e8643fb0dc04e8d65b99994d3dafff';
    public static $urls = [
        'URL_INFO'      => '/song/get-song-info'
    ];

    public function generateURL($url, $id = null) {
        $hash = hash('sha256', 'ctime='.getTimestamp().'id='.$id);
        $sig = hash_hmac('sha512', $url . $hash, $this->secrectKey);
        $result = $this->baseURL.$url.'?ctime='.getTimestamp().'&sig='.$sig.'&api_key='.$this->apiKey;
        if ($id !== null) {
            $result .= '&id='.$id;
        }
        return $result;
    }

    private function getTimestamp() 
    {
        $date = new DateTime();
        return $date->getTimestamp();
    }
}
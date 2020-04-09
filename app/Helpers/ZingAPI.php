<?php

namespace App\Helpers;

use DateTime;

class ZingAPI
{
    private $baseURL = 'https://zingmp3.vn/api';
    private $secrectKey = '10a01dcf33762d3a204cb96429918ff6';
    private $apiKey = '38e8643fb0dc04e8d65b99994d3dafff';
    public const URL_INFO = '/song/get-song-info';
    public const URL_SEARCH = '/search/multi';
    public const URL_PLAYLIST = '/playlist/get-songs';
    public const URL_DOWNLOAD = '/download/get-streamings';

    /*
    * Generate url for all task
    * @return string - full url
    */
    public function generateURL(string $url, string $id = null, string $query = null)
    {
        $params = [
            'ctime' => $this->getTimestamp()
        ];
        if ($id != null) {
            $params['id'] = $id;
        }
        $queryString = $this->generateQuery($params); //Create query string from list parameter
        $signature = $this->generateSignature($url, str_replace('&', '', $queryString));
        $result = $this->baseURL.$url.'?api_key='.$this->apiKey.'&sig='.$signature.'&'.$queryString;
        // Append query if it not null
        if ($query != null) {
            $result = $result.'&q='.$query;
        }
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
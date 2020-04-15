<?php

namespace App\Helpers\Crawler;

class ZingCrawler extends BaseCrawler
{
    public function getIdSong($url = null)
    {
        if ($url == null) return false;
        $source = parent::getSourceFromURL($url);
        $idPattern = '/"url": "https:\/\/zingmp3.vn\/[a-zA-Z-]+\/[a-zA-Z-]+\/([a-zA-z0-9]+)\.html.*",/';
        preg_match_all($idPattern, $source, $matches);
        // Check matches result
        if (sizeof($matches) > 1 && sizeof($matches[1]) > 1)
            return $matches[1][1];
        return false;
    }
}
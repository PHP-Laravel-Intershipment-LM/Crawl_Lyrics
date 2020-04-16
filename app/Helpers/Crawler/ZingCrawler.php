<?php

namespace App\Helpers\Crawler;

class ZingCrawler extends BaseCrawler
{
    public function getIdSong($url = null)
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
}
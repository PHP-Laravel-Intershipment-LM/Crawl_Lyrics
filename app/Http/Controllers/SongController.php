<?php

namespace App\Http\Controllers;

use App\Helpers\ZingAPI;
use App\Helpers\Crawler;
use Illuminate\Http\Request;

class SongController extends Controller
{

    public function findSong(Request $request)
    {
        // Check if request is valid
        if (!$request->filled('q')) {
            return response()->json([
                'status'    => 'false',
                'message'   => 'Parameter is unvalid'
            ], 500);
        }
        $querySearch = $request->input('q');
        $apiGenerator = new ZingAPI();
        $crawler = new Crawler();
        $urlSearch = $apiGenerator->generateURL(ZingAPI::URL_SEARCH, null, $querySearch);
        $result = $crawler->getSourceFromURL($urlSearch);
        return response()->json([
            'status'    => true,
            'data'      => json_decode($result, 1)['data']
        ], 200);
    }

    public function getInfo(Request $request)
    {
        // Check if request is valid
        if (!$request->filled('id')) {
            return response()->json([
                'status'    => 'false',
                'message'   => 'Parameter is unvalid'
            ], 500);
        }
        $id = $request->input('id');
        $apiGenerator = new ZingAPI();
        $crawler = new Crawler();
        $urlSearch = $apiGenerator->generateURL(ZingAPI::URL_INFO, $id, null);
        $result = $crawler->getSourceFromURL($urlSearch);
        return response()->json([
            'status'    => true,
            'data'      => json_decode($result, 1)['data']
        ], 200);
    }


    public function getPlaylist(Request $request)
    {
        // Check if request is valid
        if (!$request->filled('id')) {
            return response()->json([
                'status'    => 'false',
                'message'   => 'Parameter is unvalid'
            ], 500);
        }
        $id = $request->input('id');
        $apiGenerator = new ZingAPI();
        $crawler = new Crawler();
        $urlSearch = $apiGenerator->generateURL(ZingAPI::URL_PLAYLIST, $id, null);
        $result = $crawler->getSourceFromURL($urlSearch);
        return response()->json([
            'status'    => true,
            'data'      => json_decode($result, 1)['data']
        ], 200);
    }

    public function getStreaming(Request $request)
    {
        // Check if request is valid
        if (!$request->filled('id')) {
            return response()->json([
                'status'    => 'false',
                'message'   => 'Parameter is unvalid'
            ], 500);
        }
        $id = $request->input('id');
        $apiGenerator = new ZingAPI();
        $crawler = new Crawler();
        $urlSearch = $apiGenerator->generateURL(ZingAPI::URL_DOWNLOAD, $id, null);
        $result = $crawler->getSourceFromURL($urlSearch);
        return response()->json([
            'status'    => true,
            'data'      => json_decode($result, 1)['data']
        ], 200);
    }
}

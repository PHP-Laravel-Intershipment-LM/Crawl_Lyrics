<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('song/find', 'ZingMp3\SongAPIController@findSong');
Route::get('song/info', 'ZingMp3\SongAPIController@getInfo');
Route::get('song/download', 'ZingMp3\SongAPIController@getStreaming');
Route::get('playlist', 'ZingMp3\PlaylistAPIController@getPlaylist');
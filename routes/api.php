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
Route::get('song/find', 'SongAPIController@findSong');
Route::get('song/info', 'SongAPIController@getInfo');
Route::get('song/download', 'SongAPIController@getStreaming');
Route::get('playlist', 'PlaylistAPIController@getPlaylist');
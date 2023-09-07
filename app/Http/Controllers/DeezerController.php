<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DeezerController extends BaseController
{
    public function albumSearch(Request $request)
    {
        $albumId = $request->id;
        $response = Http::get('https://api.deezer.com/album/' . $albumId);
        $data = [];
        if ($response) {
            $data = $response->json();
        }
        return $this->sendResponse($data, 'Albums by id - An album object');
    }

    public function artistSearch(Request $request)
    {
        $artistId = $request->id;
        $response = Http::get('https://api.deezer.com/artist/' . $artistId);
        $data = [];
        if ($response) {
            $data = $response->json();
        }
        return $this->sendResponse($data, 'Artist by id - An artist object');
    }

    public function songSearch(Request $request)
    {
        $search = $request->q;
        $response = Http::get('https://api.deezer.com/search?q=' . $search);
        $data = [];
        if ($response) {
            $data = $response->json();
        }
        return $this->sendResponse($data, 'Search tracks');
    }
}

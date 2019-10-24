<?php

namespace App\Http\Classes;

use GuzzleHttp\Client;

class Delfi
{

    protected $url = 'https://www.delfi.lv/rss/?channel=';

    public function Rss()
    {
        $client = new Client();
        $result = $client->request('GET',
            $this->url.'delfi',
            [
                'headers' => ['Accept' => 'application/rss+xml'],
//                'timeout' => 120
            ])->getBody()->getContents(10);
        $res = new \SimpleXMLElement($result);
        $response=xml2array($res); //helper Xml
        return $response;
    }

    public function myRss($slug){
        $client = new Client();
        $result = $client->request('GET',
            $this->url.$slug,
            [
                'headers' => ['Accept' => 'application/rss+xml'],
//                'timeout' => 120
            ])->getBody()->getContents();
        $res = new \SimpleXMLElement($result);
        $response=xml2array($res); //helper Xml
        return $response;
    }
}

<?php

namespace App\Http\Classes;

use GuzzleHttp\Client;

class Delfi
{

    protected $url = 'https://www.delfi.lv/rss/?channel=delfi';

    public function Rss()
    {
        $client = new Client();
        $result = $client->request('GET',
            $this->url,
            [
                'headers' => ['Accept' => 'application/rss+xml'],
//                'timeout' => 120
            ])->getBody()->getContents();
        $res = new \SimpleXMLElement($result);
        $response=xml2array($res); //helper Xml
        return $response;
    }
}

<?php

namespace kazip\synonymize;

use GuzzleHttp\Client;

class Synonymize {

    private $key;
    private $url;
    private $client;

    public function __construct($key, $url = 'http://sn.derium.ru') {
        $this->key = $key;
        $this->url = $url;
        $this->client = new Client();
    }

    public function synonym($text)
    {
        $params = [
            'key' => $this->key,
            'article' => $text,
        ];
        $res = $this->client->post($this->url, ['form_params'=>$params]);
        $json = json_decode($res->getBody());
        if (!$json || !isset($json->code)) {
            throw new \Exception('Invalid JSON format: ' . $res->getBody());
        }

        if ($json->code != 0) {
            throw new \Exception('Error: ' . $json->error);
        } else {
            return $json->result;
        }

    }

}
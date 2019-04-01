<?php


namespace Flex\Express;


use GuzzleHttp\Client;

class Express
{
    protected $api = '';
    protected $app_id;
    protected $app_key;
    protected $guzzleOptions = [];

    public function __construct($app_id, $app_key)
    {
        $this->app_id = $app_id;
        $this->app_key = $app_key;
    }

    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    public function setGuzzleOptions($options)
    {
        $this->guzzleOptions = $options;
    }
}
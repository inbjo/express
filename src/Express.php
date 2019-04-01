<?php


namespace Flex\Express;


use Flex\Express\Exceptions\InvalidArgumentException;
use GuzzleHttp\Client;

class Express
{
    protected $api = '';
    protected $type;
    protected $app_id;
    protected $app_key;
    protected $guzzleOptions = [];

    /**
     * Express constructor.
     * @param $app_id
     * @param $app_key
     * @param string $type
     * @throws InvalidArgumentException
     */
    public function __construct($app_id, $app_key, $type = 'kuaidi100')
    {
        if (empty($app_id)) {
            throw new InvalidArgumentException('APP Id Can not be empty');
        }

        if (empty($app_key)) {
            throw new InvalidArgumentException('APP key Can not be empty');
        }

        if (!in_array(strtolower($type), ['kuaidi100', 'kdniao'])) {
            throw new InvalidArgumentException('Unsupported Type');
        }

        $this->type = $type;
        $this->app_id = $app_id;
        $this->app_key = $app_key;
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    /**
     * @return Client
     */
    public function getGuzzleOptions()
    {
        return new Client($this->guzzleOptions);
    }

    /**
     * @param $options
     */
    public function setGuzzleOptions($options)
    {
        $this->guzzleOptions = $options;
    }

    /**
     * 快递鸟查询
     * @param $tracking_code
     * @param $shipping_code
     * @param string $order_code
     * @return array
     * @throws InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function kdniao($tracking_code, $shipping_code, $order_code = '')
    {
        if ($this->type != 'kdniao') {
            throw new InvalidArgumentException('Inconsistent Key Type');
        }

        $express = new Kdniao($this->app_id, $this->app_key);
        return $express->track($tracking_code, $shipping_code, $order_code);
    }

    /**
     * 快递100查询
     * @param $tracking_code
     * @param $shipping_code
     * @param $phone
     * @return array
     * @throws InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function kuaidi100($tracking_code, $shipping_code, $phone)
    {
        if ($this->type != 'kuaidi100') {
            throw new InvalidArgumentException('Inconsistent Key Type');
        }

        $express = new Kuaidi100($this->app_id, $this->app_key);
        return $express->track($tracking_code, $shipping_code, $phone);
    }
}
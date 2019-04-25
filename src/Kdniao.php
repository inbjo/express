<?php


namespace Flex\Express;

use Flex\Express\Exceptions\HttpException;
use Flex\Express\Exceptions\InvalidArgumentException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Kdniao
{
    protected $api = 'http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx';
    protected $app_id;
    protected $app_key;

    /**
     * Kuaidi100 constructor.
     * @param $app_id
     * @param $app_key
     */
    public function __construct($app_id, $app_key)
    {
        $this->app_id = $app_id;
        $this->app_key = $app_key;
    }

    /**
     * 快递查询
     * @param string $tracking_code 快递单号
     * @param string $shipping_code 物流公司编号
     * @param string $order_code 订单编号(选填)
     * @return array
     * @throws InvalidArgumentException
     * @throws HttpException
     */
    public function track($tracking_code, $shipping_code, $order_code = '')
    {
        if (empty($tracking_code)) {
            throw new InvalidArgumentException('TrackingCode Can not be empty');
        }

        if (empty($shipping_code)) {
            throw new InvalidArgumentException('ShippingCode Can not be empty');
        }

        $requestData = [
            'LogisticCode' => $tracking_code,
            'ShipperCode' => $shipping_code,
            'OrderCode' => $order_code,
        ];
        $requestData = json_encode($requestData);

        $post = array(
            'EBusinessID' => $this->app_id,
            'RequestType' => '1002',
            'RequestData' => urlencode($requestData),
            'DataType' => '2',
            'DataSign' => $this->encrypt($requestData, $this->app_key)
        );

        try {
            $response = $this->getHttpClient()->request('POST', $this->api, [
                'form_params' => $post
            ])->getBody()->getContents();
        } catch (GuzzleException $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response, true);
    }

    /**
     * 数据签名
     * @param $data
     * @param $appkey
     * @return string
     */
    private function encrypt($data, $appkey)
    {
        return urlencode(base64_encode(md5($data . $appkey)));
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

}
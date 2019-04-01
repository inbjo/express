<?php


namespace Flex\Express;

use Flex\Express\Exceptions\InvalidArgumentException;

class Kdniao extends Express
{
    protected $api = 'http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx';

    /**
     * 快递查询
     * @param string $tracking_code 快递单号
     * @param string $shipping_code 物流公司编号
     * @param string $order_code 订单编号(选填)
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws InvalidArgumentException
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

        $response = $this->getHttpClient()->request('POST', $this->api, [
            'form_params' => $post
        ])->getBody()->getContents();

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

}
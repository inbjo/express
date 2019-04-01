<?php


namespace Flex\Express;

use Flex\Express\Exceptions\InvalidArgumentException;

class Kuaidi100 extends Express
{
    protected $api = 'https://poll.kuaidi100.com/poll/query.do';

    /**
     * 快递查询
     * @param string $tracking_code 快递单号
     * @param string $shipping_code 物流公司单号
     * @param string $phone
     * @return array
     * @throws InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function track($tracking_code, $shipping_code, $phone = '')
    {
        if (empty($tracking_code)) {
            throw new InvalidArgumentException('TrackingCode Can not be empty');
        }

        if (empty($shipping_code)) {
            throw new InvalidArgumentException('ShippingCode Can not be empty');
        }

        if ($shipping_code == 'shunfeng' && empty($phone)) {
            throw new InvalidArgumentException('This Order Mobile Can not be empty');
        }

        $post['customer'] = $this->app_id;
        $data = [
            'com' => $shipping_code,
            'num' => $tracking_code
        ];

        if (!empty($mobile)) {
            $data['mobiletelephone'] = $phone;
        }

        $post['param'] = json_encode($data);
        $post['sign'] = strtoupper(md5($post['param'] . $this->app_key . $post['customer']));

        $response = $this->getHttpClient()->request('POST', $this->api, [
            'form_params' => $post
        ])->getBody()->getContents();

        return json_decode($response, true);
    }
}



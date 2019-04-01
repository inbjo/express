<?php


namespace Flex\Express;

class Kuaidi100 extends Express
{
    protected $api = 'https://poll.kuaidi100.com/poll/query.do';

    /**
     * 快递查询
     * @param string $tracking_code 快递单号
     * @param string $shipping_code 物流公司单号
     * @param string $mobile 手机号(查顺丰单号需要收件人手机号)
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function track($tracking_code, $shipping_code, $mobile = '')
    {
        $post['customer'] = $this->app_id;
        $data = [
            'com' => $shipping_code,
            'num' => $tracking_code
        ];

        if (!empty($mobile)) {
            $data['mobiletelephone'] = $mobile;
        }

        $post['param'] = json_encode($data);
        $post['sign'] = strtoupper(md5($post['param'] . $this->app_key . $post['customer']));

        $response = $this->getHttpClient()->request('POST', $this->api, [
            'form_params' => $post
        ])->getBody()->getContents();

        return json_decode($response, true);
    }
}



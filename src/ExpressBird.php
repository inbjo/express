<?php

/*
 * This file is part of the flex/express.
 *
 * (c) Flex<2345@mail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Flex\Express;

use Flex\Express\Exceptions\HttpException;
use Flex\Express\Exceptions\InvalidArgumentException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ExpressBird
{
    protected $api = 'http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx';

    protected $app_id;

    protected $app_key;

    protected $guzzleOptions = [];

    /**
     * Kuaidi100 constructor.
     *
     * @param $app_id
     * @param $app_key
     */
    public function __construct($app_id, $app_key)
    {
        $this->app_id = $app_id;
        $this->app_key = $app_key;
    }

    /**
     * 快递查询.
     *
     * @param string $tracking_code 快递单号
     * @param string $shipping_code 物流公司编号
     * @param string $order_code    订单编号(选填)
     *
     * @return string
     *
     * @throws InvalidArgumentException
     * @throws HttpException
     */
    public function track($tracking_code = '', $shipping_code = '', $order_code = '')
    {
        if (empty($tracking_code)) {
            throw new InvalidArgumentException('TrackingCode is required');
        }

        if (empty($shipping_code)) {
            throw new InvalidArgumentException('ShippingCode is required');
        }

        $allow_shipping_code = ['SF', 'HTKY', 'ZTO', 'STO', 'YTO', 'YD', 'YZPY', 'EMS', 'HHTT', 'JD', 'UC', 'DBL', 'ZJS', 'TNT', 'UPS', 'DHL', 'FEDEX', 'FEDEX_GJ', 'AJ', 'ALKJWL', 'AX', 'AYUS', 'AMAZON', 'AOMENYZ', 'ANE', 'ADD', 'AYCA', 'AXD', 'ANEKY', 'BDT', 'BETWL', 'BJXKY', 'BNTWL', 'BFDF', 'BHGJ', 'BFAY', 'BTWL', 'CFWL', 'CHTWL', 'CXHY', 'CG', 'CITY100', 'CJKD', 'CNPEX', 'COE', 'CSCY', 'CDSTKY', 'CTG', 'CRAZY', 'CBO', 'CND', 'DSWL', 'DLG', 'DTWL', 'DJKJWL', 'DEKUN', 'DBLKY', 'DML', 'ETK', 'EWE', 'KFW', 'FKD', 'FTD', 'FYKD', 'FASTGO', 'FT', 'GD', 'GTO', 'GDEMS', 'GSD', 'GTONG', 'GAI', 'GKSD', 'GTSD', 'HFWL', 'HGLL', 'HLWL', 'HOAU', 'HOTSCM', 'HPTEX', 'hq568', 'HQSY', 'HXLWL', 'HXWL', 'HFHW', 'HLONGWL', 'HQKD', 'HRWL', 'HTKD', 'HYH', 'HYLSD', 'HJWL', 'JAD', 'JGSD', 'JIUYE', 'JXD', 'JYKD', 'JYM', 'JGWL', 'JYWL', 'JDKY', 'CNEX', 'KYSY', 'KYWL', 'KSDWL', 'KBSY', 'LB', 'LJSKD', 'LHT', 'MB', 'MHKD', 'MK', 'MDM', 'MRDY', 'MLWL', 'NF', 'NEDA', 'PADTF', 'PANEX', 'PJ', 'PCA', 'QCKD', 'QRT', 'QUICK', 'QXT', 'RQ', 'QYZY', 'RFD', 'RRS', 'RFEX', 'SAD', 'SNWL', 'SAWL', 'SBWL', 'SDWL', 'SFWL', 'ST', 'STWL', 'SUBIDA', 'SDEZ', 'SCZPDS', 'SURE', 'SS', 'STKD', 'TAIWANYZ', 'TSSTO', 'TJS', 'TYWL', 'TLWL', 'UAPEX', 'ULUCKEX', 'UEQ', 'WJK', 'WJWL', 'WHTZX', 'WPE', 'WXWL', 'WTP', 'WTWL', 'XCWL', 'XFEX', 'XYT', 'XJ', 'YADEX', 'YCWL', 'YCSY', 'YDH', 'YDT', 'YFHEX', 'YFSD', 'YTKD', 'YXKD', 'YUNDX', 'YMDD', 'YZBK', 'YZTSY', 'YFSUYUN', 'YSDF', 'YF', 'YDKY', 'YL', 'ZENY', 'ZHQKD', 'ZTE', 'ZTKY', 'ZTWL', 'SJ', 'ZTOKY', 'ZYKD', 'WM', 'ZMKM', 'ZHWL', 'AAE', 'ACS', 'ADP', 'ANGUILAYOU', 'APAC', 'ARAMEX', 'AT', 'AUSTRALIA', 'BEL', 'BHT', 'BILUYOUZHE', 'BR', 'BUDANYOUZH', 'CDEK', 'CA', 'DBYWL', 'DDWL', 'DGYKD', 'DLGJ', 'DHL_DE', 'DHL_EN', 'DHL_GLB', 'DHLGM', 'DK', 'DPD', 'DPEX', 'D4PX', 'EMSGJ', 'EKM', 'EPS', 'ESHIPPER', 'FCWL', 'FX', 'FQ', 'FLYZ', 'FZGJ', 'GJEYB', 'GJYZ', 'GE2D', 'GT', 'GLS', 'IOZYZ', 'IADLYYZ', 'IAEBNYYZ', 'IAEJLYYZ', 'IAFHYZ', 'IAGLYZ', 'IAJYZ', 'IALBYZ', 'IALYYZ', 'IASBJYZ', 'IBCWNYZ', 'IBDLGYZ', 'IBDYZ', 'IBELSYZ', 'IBHYZ', 'IBJLYYZ', 'IBJSTYZ', 'IBLNYZ', 'IBOLYZ', 'IBTD', 'IBYB', 'ICKY', 'IDGYZ', 'IWDMLYZ', 'IWGDYZ', 'IWKLEMS', 'IWKLYZ', 'IWLGYZ', 'ILKKD', 'IWLYZ', 'IXGLDNYYZ', 'IE', 'IXPWL', 'IYDYZ', 'IXPSJ', 'IEGDEYZ', 'IELSYZ', 'IFTWL', 'IGDLPDYZ', 'IGSDLJYZ', 'IHGYZ', 'IHHWL', 'IHLY', 'IHSKSTYZ', 'IHSYZ', 'IJBBWYZ', 'IJEJSSTYZ', 'IJKYZ', 'IJNYZ', 'IJPZYZ', 'IKNDYYZ', 'IKNYYZ', 'IKTDWEMS', 'ILMNYYZ', 'IMEDWYZ', 'IMETYZ', 'INRLYYZ', 'ISEWYYZ', 'ISPLSYZ', 'IWZBKSTYZ', 'IXBYYZ', 'IXJPEMS', 'IXLYZ', 'IXXLYZ', 'IYDLYZ', 'IYGYZ', 'IYMNYYZ', 'IYMYZ', 'IZLYZ', 'JP', 'JFGJ', 'JGZY', 'JXYKD', 'JLDT', 'JPKD', 'SYJHE', 'LYT', 'LHKDS', 'SHLDHY', 'NL', 'NSF', 'ONTRAC', 'OCS', 'QQYZ', 'POSTEIBE', 'PAPA', 'QYHY', 'VENUCIA', 'RDSE', 'SKYPOST', 'SWCH', 'SDSY', 'SK', 'STONG', 'STO_INTL', 'JYSD', 'TAILAND138', 'USPS', 'UPU', 'VCTRANS', 'XKGJ', 'XD', 'XGYZ', 'XLKD', 'XSRD', 'XYGJ', 'XYGJSD', 'YAMA', 'YODEL', 'YHXGJSD', 'YUEDANYOUZ', 'YMSY', 'YYSD', 'YJD', 'YBG', 'YJ', 'AOL', 'BCWELT', 'BN', 'UBONEX', 'UEX', 'YDGJ', 'ZY_AG', 'ZY_AOZ', 'ZY_AUSE', 'ZY_AXO', 'ZY_BH', 'ZY_BEE', 'ZY_BL', 'ZY_BM', 'ZY_BT', 'ZY_CM', 'ZY_EFS', 'ZY_ESONG', 'ZY_FD', 'ZY_FG', 'ZY_FX', 'ZY_FXSD', 'ZY_FY', 'ZY_HC', 'ZY_HYSD', 'ZY_JA', 'ZY_JD', 'ZY_JDKD', 'ZY_JDZY', 'ZY_JH', 'ZY_JHT', 'ZY_LBZY', 'ZY_LX', 'ZY_MGZY', 'ZY_MST', 'ZY_MXZY', 'ZY_QQEX', 'ZY_RT', 'ZY_RTSD', 'ZY_SDKD', 'ZY_SFZY', 'ZY_ST', 'ZY_TJ', 'ZY_TM', 'ZY_TN', 'ZY_TPY', 'ZY_TSZ', 'ZY_TWC', 'ZY_RDGJ', 'ZY_TX', 'ZY_TY', 'ZY_DGHT', 'ZY_DYW', 'ZY_WDCS', 'ZY_TZH', 'ZY_UCS', 'ZY_XC', 'ZY_XF', 'ZY_XIYJ', 'ZY_YQ', 'ZY_YSSD', 'ZY_YTUSA', 'ZY_ZCSD', 'ZYZOOM', 'ZH', 'ZO', 'ZSKY', 'ZWSY', 'ZZJH'];

        if (!in_array($shipping_code, $allow_shipping_code)) {
            throw new InvalidArgumentException('Current ShippingCode is not support');
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
            'DataSign' => $this->encrypt($requestData, $this->app_key),
        );

        try {
            $response = $this->getHttpClient()->request('POST', $this->api, [
                'form_params' => $post,
            ])->getBody()->getContents();
        } catch (GuzzleException $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 数据签名.
     *
     * @param $data
     * @param $appkey
     *
     * @return string
     */
    private function encrypt($data, $appkey)
    {
        return urlencode(base64_encode(md5($data.$appkey)));
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

<h1 align="center"> Express </h1>

<p align="center">支持快递鸟、快递100的快递查询SDK</p>

[![Build Status](https://travis-ci.org/inbjo/express.svg?branch=master)](https://travis-ci.org/inbjo/express)
[![StyleCI build status](https://github.styleci.io/repos/178779366/shield)](https://github.styleci.io/repos/178779366)
[![Latest Stable Version](https://poser.pugx.org/flex/express/v/stable)](https://packagist.org/packages/flex/express)
[![Total Downloads](https://poser.pugx.org/flex/express/downloads)](https://packagist.org/packages/flex/express)
[![License](https://poser.pugx.org/flex/express/license)](https://packagist.org/packages/flex/express)


## 安装

```shell
$ composer require flex/express -vvv
```
## 配置

在使用本扩展之前，你需要去 [快递100](https://www.kuaidi100.com/openapi/applyapi.shtml) 或者 [快递鸟](http://www.kdniao.com/reg) 注册申请，获取到APP_id和APP_key。

## Usage
### 快递100
```php
use Flex\Express\Express100;

$express = new Express100('app_id','app_key');
$info = $express->track($tracking_code, $shipping_code, $phone); //快递单号 物流公司编号 收件人手机号(顺丰必填 其他快递选填)
```
示例:
```json
{
    "message": "ok",
    "nu": "888888888888",
    "ischeck": "1",
    "condition": "F00",
    "com": "shunfeng",
    "status": "200",
    "state": "3",
    "data": [
        {
            "time": "2019-03-08 19:11:51",
            "ftime": "2019-03-08 19:11:51",
            "context": "[安高广场速运营业点]快件已发车"
        },
        {
            "time": "2019-03-08 18:56:12",
            "ftime": "2019-03-08 18:56:12",
            "context": "[安高广场速运营业点]快件在【合肥蜀山区安高广场营业点】已装车,准备发往 【合肥经开集散中心】"
        },
        {
            "time": "2019-03-08 18:50:52",
            "ftime": "2019-03-08 18:50:52",
            "context": "[安高广场速运营业点]顺丰速运 已收取快件"
        }
    ]
}
```

### 快递鸟
```php
use Flex\Express\ExpressBird;

$express = new ExpressBird('app_id','app_key'); 
$info = $express->track($tracking_code, $shipping_code，$order_code); //快递单号 物流公司编号 订单编号(选填)
```
示例:
```json
{
    "LogisticCode": "8888888888888888",
    "ShipperCode": "YTO",
    "Traces": [
        {
            "AcceptStation": "【四川省直营市场部公司】 取件人: 四川省直营市场部41 已收件",
            "AcceptTime": "2019-03-21 11:03:40"
        },
        {
            "AcceptStation": "【四川省直营市场部公司】 已收件",
            "AcceptTime": "2019-03-21 13:45:01"
        },
        {
            "AcceptStation": "【成都转运中心】 已收入",
            "AcceptTime": "2019-03-21 22:40:01"
        }
    ],
    "State": "3",
    "OrderCode": "",
    "EBusinessID": "100000",
    "Success": true
}
```
### 通用方法
```php
use Flex\Express\Express;


$express = new Express($app_id,$app_key,$type); //$type支持类型'express100'、'expressbird'

//快递鸟$additional=['order_code'=>111111] 快递100 $additional=['phone'=>'18899996666']
$info = $express->track($tracking_code, $shipping_code，$additional); ////查询物流 快递单号 额外参数
```

 ### 在 Laravel 中使用
 
 在 Laravel 中使用也是同样的安装方式，配置写在 `config/services.php` 中：
 
 ```php
     .
     .
     .
      'express' => [
         'id' => env('EXPRESS_ID'),
         'key' => env('EXPRESS_KEY'),
         'type' => env('EXPRESS_TYPE'),
     ],
 ```
 
 然后在 `.env` 中配置 `EXPRESS_ID`、`EXPRESS_KEY`、`EXPRESS_TYPE`；
 
 ```env
 EXPRESS_ID=xxxxxxxxxxxxxxxxxxxxx
 EXPRESS_KEY=xxxxxxxxxxxxxxxxxxxxx
 EXPRESS_TYPE=express100
 ```
 
 可以用两种方式来获取 `Flex\Express\Express` 实例：
 
 #### 方法参数注入
 
 ```php
     .
     .
     .
     public function edit(Express $express) 
     {
         $response = $express->track('888888888','YTO');
     }
     .
     .
     .
 ```
 
 #### 服务名访问
 
 ```php
     .
     .
     .
     public function edit() 
     {
         $response = app('express')->track('888888888','YTO');
     }
     .
     .
     .
 
 ```
 
 ## 参考
 
 - [快递100接口文档](https://www.kuaidi100.com/openapi/api_post.shtml)
 - [快递100快递公司编码](https://blog.csdn.net/u011816231/article/details/53063611)
 - [快递鸟接口文档](http://www.kdniao.com/documents)
 - [快递鸟快递公司编码](http://www.kdniao.com/documents)

## License

MIT
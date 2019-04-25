<h1 align="center"> express </h1>

<p align="center">支持快递鸟、快递100的快递查询SDK</p>


## Installing

```shell
$ composer require flex/express -vvv
```

## Usage
### 快递100
```php
use Flex\Express\Kuaidi100;

//初始化类
$express = new Kuaidi100('app_id','app_key');
//查询物流 快递单号 物流公司编号 手机人手机号(顺丰必填 其他快递选填)
$info = $express->track($tracking_code, $shipping_code, $phone);
```

### 快递鸟
```php
use Flex\Express\Kdniao;

//初始化类
$express = new Kdniao('app_id','app_key');
//查询物流 快递单号 物流公司编号 订单编号(选填)
$info = $express->track($tracking_code, $shipping_code，$order_code);
```
### 通用方法
```php
use Flex\Express\Express;

//初始化类 $type支持类型'kuaidi100'、'kdniao'
$express = new Express($app_id,$app_key,$type);
//查询物流 快递单号 额外参数
//快递鸟$additional=['order_code'=>111111] 快递100 $additional=['phone'=>'18899996666']
$info = $express->track($tracking_code, $shipping_code，$additional);
```

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/inbjo/express/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/inbjo/express/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT
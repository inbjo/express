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

use Flex\Express\Exceptions\InvalidArgumentException;

class Express
{
    protected $type;

    protected $app_id;

    protected $app_key;

    /**
     * Express constructor.
     *
     * @param string $app_id
     * @param string $app_key
     * @param string $type
     *
     * @throws InvalidArgumentException
     */
    public function __construct($app_id, $app_key, $type = 'express100')
    {
        if (empty($app_id)) {
            throw new InvalidArgumentException('APP Id Can not be empty');
        }

        if (empty($app_key)) {
            throw new InvalidArgumentException('APP key Can not be empty');
        }

        if (!in_array(strtolower($type), ['express100', 'expressbird'])) {
            throw new InvalidArgumentException('Unsupported Type');
        }

        $this->type = $type;
        $this->app_id = $app_id;
        $this->app_key = $app_key;
    }

    /**
     * 查询物流
     *
     * @param $tracking_code
     * @param $shipping_code
     * @param array $additional
     *
     * @return array
     *
     * @throws Exceptions\HttpException
     * @throws InvalidArgumentException
     */
    public function track($tracking_code, $shipping_code, $additional = [])
    {
        if ('express100' == $this->type) {
            if (isset($additional['phone'])) {
                $phone = $additional['phone'];
            } else {
                $phone = '';
            }
            $express = new Express100($this->app_id, $this->app_key);

            return $express->track($tracking_code, $shipping_code, $phone);
        }

        if ('expressbird' == $this->type) {
            if (isset($additional['order_code'])) {
                $order_code = $additional['order_code'];
            } else {
                $order_code = '';
            }
            $express = new ExpressBird($this->app_id, $this->app_key);

            return $express->track($tracking_code, $shipping_code, $order_code);
        }

        return [];
    }
}

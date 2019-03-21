<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/3/21
 * Time: 9:56 AM
 */

namespace epii\mq\client\driver;

interface IMqClient
{
    public function add($list);

    public function finish(string $ret_code);
}
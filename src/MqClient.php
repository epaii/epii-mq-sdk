<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/3/21
 * Time: 9:38 AM
 */

namespace epii\mq\client;

use epii\api\result\ApiResult;
use epii\mq\client\driver\IMqClient;


class MqClient
{
    /**
     * @var IMqClient
     */
    private static $client = null;

    public static function init(IMqClient $client)
    {

        self::$client = $client;
    }

    private static $list = [];

    public static function add_push($name, $cmd, $plan_time, $level = 0)
    {
        self::$list[] = ["name" => $name, "cmd" => $cmd, "plan_time" => $plan_time, "level" => $level];
    }

    public static function add_submit(IMqClient $client = null)
    {

        $ret = self::getClicent($client)->add(self::$list);
        self::$list = [];
        return new ApiResult($ret);

    }

    public static function finish($ret_code = "0", IMqClient $client = null)
    {
        if (self::getWorkId())
            return new ApiResult(self::getClicent($client)->finish($ret_code));
        return new ApiResult();
    }

    /**
     * @param $client
     * @return IMqClient
     */
    private static function getClicent($client)
    {
        if ($client === null)
            $client = self::$client;
        if ($client === null) {
            echo "MqClient need set a IMqClient,you can user MqClient::init()  ";
            exit;
        }
        return $client;
    }

    public static function getWorkId()
    {
        global $argv;

        if (preg_match("/cli/i", php_sapi_name()) ? true : false) {
            if (($c = count($argv)) > 2) {
                if ($argv[$c - 2] == "--work_id") {
                    return (int)$argv[$c - 1];
                }
            }
        }
        return 0;
    }

}
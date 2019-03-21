<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/3/21
 * Time: 9:58 AM
 */

namespace epii\mq\client\driver;


use epii\mq\client\MqClient;

class local_cli implements IMqClient
{
    private $cmd_pre = null;
    private $cache_dir = null;

    public function __construct($php_path, $php_root_file, $cache_dir = null)
    {

        $this->cmd_pre = $php_path . " " . $php_root_file;
        if ($cache_dir) {
            $this->cache_dir = str_replace("\\", "/", rtrim($cache_dir, DIRECTORY_SEPARATOR));
            if (!is_dir($this->cache_dir)) {
                mkdir($this->cache_dir, 0777, true);
            }
        }


    }

    public function add($list)
    {
        if ($this->cache_dir === null) {
            echo "local_cli when add work need set  cache_dir";
            exit;
        }
        $file = $this->cache_dir . "/" . time() . "." . rand(90000, 100000) . rand(1, 900) . ".json";
        file_put_contents($file, json_encode($list, JSON_UNESCAPED_UNICODE));
        $ret= $this->run($this->cmd_pre . " --app api@add  --data-path \"" . $file . "\"");
        unlink($file);
        return $ret;
    }

    public function finish(string $ret_code)
    {
        // TODO: Implement finish() method.
        if ($work_id = MqClient::getWorkId())
            return $this->run($this->cmd_pre . " --app api@finish  --work-id \"" . MqClient::getWorkId() . "\" --ret-code \"" . $ret_code."\"");
        return "";
    }

    private function run($cmd)
    {

        exec($cmd, $out);
        return implode("", $out);
    }

}

添加任务

```php

require_once __DIR__ . "/vendor/autoload.php";
$client = new \epii\mq\client\driver\local_cli("php", "/Volumes/BOOTCAMP/php/phpworkspace/fayuan/crontab-scripts/root.php", __DIR__ . "/cache");
\epii\mq\client\MqClient::init($client) ;

\epii\mq\client\MqClient::add_push("ceshi", "php /Volumes/BOOTCAMP/php/phpworkspace/epii-composer-libs/epii-mq-sdk/test/test.php ".time().":".rand(1,10000), time());
$ret = \epii\mq\client\MqClient::add_submit() ;
var_dump($ret->isSuccess());
var_dump($ret->getMsg());




```
 

任务完成


```php

require_once __DIR__ . "/vendor/autoload.php";
$client = new \epii\mq\client\driver\local_cli("php", "/Volumes/BOOTCAMP/php/phpworkspace/fayuan/crontab-scripts/root.php", __DIR__ . "/cache");
\epii\mq\client\MqClient::init($client);

$ret = \epii\mq\client\MqClient::finish("0000");
var_dump($ret->isSuccess());
var_dump($ret->getMsg());


```
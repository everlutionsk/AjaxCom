<?php

require_once('../vendor/autoload.php');

use DM\AjaxCom\Handler;

$handler = new Handler();

#$handler->container('#xyds')->append('dfas');

#$handler->changeUrl('http://testurl.com', 10);
$handler->callback('testfunction');
echo $handler->respond();

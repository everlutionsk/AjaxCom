<?php

require_once('../vendor/autoload.php');

use DM\AjaxCom\Handler;

$handler = new Handler();

$handler->container('#xyds')->html('<b>dafs</b>');

echo $handler->respond();

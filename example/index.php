<?php

require_once('../vendor/autoload.php');

use DM\AjaxCom\Handler;

$handler = new Handler();

$handler->container('#xyds')->append('dfas');

echo $handler->respond();

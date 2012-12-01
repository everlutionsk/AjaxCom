<?php

require_once('../vendor/autoload.php');

use DM\AjaxCom\Handler;

$handler = new Handler();
echo $handler->respond();

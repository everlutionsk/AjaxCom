<?php

require_once('../vendor/autoload.php');

use DM\AjaxCom\Handler;


$handler = new Handler();

$handler->container('#xyds')->append('dfas')->animate(false);

#$handler->changeUrl('http://testurl.com', 10);
#$handler->callback('testfunction');
#$handler->modal();

echo json_encode($handler->respond());

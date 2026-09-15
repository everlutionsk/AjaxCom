<?php

namespace DM\AjaxCom\Tests;

use DM\AjaxCom\Handler;
use PHPUnit\Framework\TestCase;

class HandlerTest extends TestCase
{

    public function testContainer()
    {

        $ajax = new Handler();
        $container = $ajax->container('#123')->html('<b>test</b>');
        $response = $ajax->respond();

        $expected = '{"ajaxcom":[{"operation":"container","options":{"target":"#123","animate":true,"value":"<b>test<\/b>","method":"html"}}]}';
        $this->assertEquals($response, $expected);
    }
}

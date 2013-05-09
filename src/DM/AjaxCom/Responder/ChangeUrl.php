<?php

namespace DM\AjaxCom\Responder;

class ChangeUrl extends AbstractResponder
{
    const OBJECT_IDENTIFIER = 'changeurl';

    const OPTION_URL = 'url';
    const OPTION_METHOD = 'method';
    const OPTION_WAIT = 'wait';

    const PUSH = 'push';
    const REPLACE = 'replace';
    const REDIRECT = 'redirect';

    /**
     * Constructor
     *
     * @param string $url The new URL
     * @param string $method push|replace|redirect
     * @param integer $wait How long to wait until changing URL
     */
    public function __construct($url, $method, $wait = 0)
    {
        $this->registerOption(self::OPTION_URL);
        $this->registerOption(self::OPTION_METHOD);
        $this->registerOption(self::OPTION_WAIT);

        $this->setOption(self::OPTION_URL, $url);
        $this->setOption(self::OPTION_METHOD, $method);
        $this->setOption(self::OPTION_WAIT, $wait);
    }
}

<?php

namespace DM\AjaxCom\Responder;

class ChangeUrl extends AbstractResponder
{
    const OBJECT_IDENTIFIER = 'changeurl';

    const OPTION_URL = 'url';
    const OPTION_WAIT = 'wait';
    const OPTION_REDIRECT = 'redirect';

    /**
     * Constructor
     *
     * @param string $url The new URL
     * @param integer $wait How long to wait until changing URL
     * @param boolean $redirect Whether to force a redirect
     */
    public function __construct($url, $wait = 0, $redirect = false)
    {
        $this->registerOption(self::OPTION_URL);
        $this->registerOption(self::OPTION_WAIT);
        $this->registerOption(self::OPTION_REDIRECT);

        $this->setOption(self::OPTION_URL, $url);
        $this->setOption(self::OPTION_WAIT, $wait);
        $this->setOption(self::OPTION_REDIRECT, $redirect);
    }
}

<?php

namespace DM\AjaxCom\Responder;

class Callback extends AbstractResponder
{
    const OBJECT_IDENTIFIER = 'callback';

    const OPTION_FUNCTION = 'callFunction';

    /**
     * Constructor
     *
     * @param string $function
     */
    public function __construct($function)
    {
        $this->registerOption(self::OPTION_FUNCTION);
        $this->setOption(self::OPTION_FUNCTION, $function);
    }
}

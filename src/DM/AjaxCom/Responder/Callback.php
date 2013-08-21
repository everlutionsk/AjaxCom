<?php

namespace DM\AjaxCom\Responder;

class Callback extends AbstractResponder
{
    const OBJECT_IDENTIFIER = 'callback';

    const OPTION_FUNCTION = 'callFunction';
    const OPTION_PARAMS = 'params';

    /**
     * Constructor
     *
     * @param string $function
     * @param mixed $params Paramters sent to the callback function
     */
    public function __construct($function, $params = null)
    {
        $this->registerOption(self::OPTION_FUNCTION);
        $this->registerOption(self::OPTION_PARAMS);

        $this->setOption(self::OPTION_FUNCTION, $function);
        $this->setOption(self::OPTION_PARAMS, $params);
    }
}

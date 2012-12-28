<?php

namespace DM\AjaxCom\Responder;

class Modal extends AbstractResponder
{
    const OBJECT_IDENTIFIER = 'modal';

    const OPTION_WIDTH = 'width';

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

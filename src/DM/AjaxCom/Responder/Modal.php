<?php

namespace DM\AjaxCom\Responder;

class Modal extends AbstractResponder
{
    const OBJECT_IDENTIFIER = 'modal';

    const OPTION_CONTENT = 'content';

    /**
     * Constructor
     *
     * @param string $content
     */
    public function __construct($content)
    {
        $this->registerOption(self::OPTION_CONTENT);
        $this->setOption(self::OPTION_CONTENT, $content);
    }
}

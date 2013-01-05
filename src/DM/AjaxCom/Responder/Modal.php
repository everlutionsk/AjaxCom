<?php

namespace DM\AjaxCom\Responder;

class Modal extends AbstractResponder
{
    const OBJECT_IDENTIFIER = 'modal';

    const OPTION_CONTENT = 'content';

    const OPTION_TYPE = 'type';

    /**
     * Constructor
     *
     * @param string $content
     */
    public function __construct($content)
    {
        $this->registerOption(self::OPTION_CONTENT);
        $this->registerOption(self::OPTION_TYPE);
        $this->setOption(self::OPTION_CONTENT, $content);
        /**
         * @todo Make this class abstract and implement different modal types
         */
        $this->setOption(self::OPTION_TYPE, 'twitterbootstrap');
    }
}

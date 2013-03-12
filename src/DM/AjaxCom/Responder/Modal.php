<?php

namespace DM\AjaxCom\Responder;

use DM\AjaxCom\Responder\AbstractResponder;

class Modal extends AbstractResponder
{
    
    const OBJECT_IDENTIFIER = 'modal';
 
    const OPTION_TYPE = 'type';
    const OPTION_HTML = 'html';
        
    const DEFAULT_TYPE = 'twitterbootstrap';

    /**
     * Constructor
     *
     */
    public function __construct($html, $type = self::DEFAULT_TYPE)
    {
        $this->registerOption(self::OPTION_HTML);
        $this->registerOption(self::OPTION_TYPE);
    
        $this->setOption(self::OPTION_HTML, $html);
        $this->setOption(self::OPTION_TYPE, $type);
    }
}

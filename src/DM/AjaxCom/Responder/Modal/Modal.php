<?php

namespace DM\AjaxCom\Responder\Modal;

use DM\AjaxCom\Responder\AbstractResponder;

class Modal extends AbstractResponder
{
    
    const OBJECT_IDENTIFIER = 'modal';
 
    const OPTION_TYPE = 'type';
    const OPTION_HTML = 'html';
        
    const DEFAULT_TYPE = 'TwitterBootstrap';

    private $handler;


    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->registerOption(self::OPTION_HTML);
        $this->registerOption(self::OPTION_TYPE);
    }

    /**
     * Returns the modal window handler based on type
     *
     * @var string $type
     * @return ModalTypeObject
     */
    public function getHandler($type)
    {
        if(!$type) {
            $type=self::DEFAULT_TYPE;
        }
        
        $this->setOption(self::OPTION_TYPE, strtolower($type));
        $class = 'DM\\AjaxCom\\Responder\\Modal\\Type\\'.$type;
        $this->handler = new $class();
        return $this->handler;
    }

    /**
     * Render modal
     *
     * @return string
     */
    public function render()
    {
        $this->setOption(self::OPTION_HTML, $this->handler->getHtml());
        return parent::render();    
    }

}

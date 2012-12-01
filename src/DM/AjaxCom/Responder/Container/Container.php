<?php

namespace DM\AjaxCom\Responder\Container;

use DM\AjaxCom\Responder\ResponseObjectAbstract;

class Container extends ResponseObjectAbstract
{

    const OBJECT_IDENTIFIER = 'container';

    const OPTION_VALUE = 'value';
    const OPTION_TARGET = 'target';
    const OPTION_METHOD = 'method';


    /**
     * Constructor
     *
     * @param string $identifier
     */
    
     
    public function __construct($identifier=null)
    {
     
        $this->registerOption(self::OPTION_VALUE);
        $this->registerOption(self::OPTION_TARGET);
        $this->registerOption(self::OPTION_METHOD);

        if ($identifier) {
            $this->setOption(self::OPTION_TARGET, $identifier);
        }
    }

    public function append($html)
    {
        $this->setOption(self::OPTION_VALUE, $html);
        $this->setOption(self::OPTION_METHOD, 'append');
        return $this;
    }

    public function prepend($html)
    {
        $this->setOption(self::OPTION_VALUE, $html);
        $this->setOption(self::OPTION_METHOD, 'prepend');
        return $this;
    }

    public function replaceWith($html)
    {
        $this->setOption(self::OPTION_VALUE, $html);
        $this->setOption(self::OPTION_METHOD, 'replaceWith');
        return $this;
    }

    public function html($html)
    {   
        $this->setOption(self::OPTION_VALUE, $html);
        $this->setOption(self::OPTION_METHOD, 'html');
        return $this;
    }

    public function val($html)
    {
        $this->setOption(self::OPTION_VALUE, $html);
        $this->setOption(self::OPTION_METHOD, 'val');
        return $this;
    }
  
    public function remove()
    {
        $this->setOption(self::OPTION_METHOD, 'remove');
        return $this;
    }


}

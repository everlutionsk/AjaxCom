<?php

namespace DM\AjaxCom\Responder\Container;

use DM\AjaxCom\Responder\ResponseObjectAbstract;

class Container extends ResponseObjectAbstract
{

    const OBJECT_IDENTIFIER = 'container';

    /**
     * Constructor
     *
     * @param string $identifier
     */
    
     
    public function __construct($identifier=null)
    {
     
        $this->registerOption('html');
        $this->registerOption('target');
      
        if ($identifier) {
            $this->setOption('target', $identifier);
        }
    }

    public function append($html)
    {
    
    }

    public function prepend($html)
    {
        
    }

    public function replaceWith($html)
    {
    
    }

    public function html($html)
    {   
        $this->setOption('html', 'dasf');
        
    }

    public function val($html)
    {
    }
  
    public function remove()
    {
            
    }


}

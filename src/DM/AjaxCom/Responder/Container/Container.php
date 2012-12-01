<?php

namespace DM\AjaxCom\Responder\Container;

use DM\AjaxCom\Responder\ResponseObjectAbstract;

class Container extends ResponseObjectAbstract
{


    /**
     * Constructor
     *
     * @param string $identifier
     */
    
     
    public function __construct($identifier=null)
    {
     
        parent::__construct();
        
        if ($identifier) {
            $this->setContainer($identifier);
        }

        $this->registerOption('html');

    }


    protected function setObjectIdentifier()
    {
        return "container";    
    }

    public function setContainer()
    {
        
    }

    public function getContainer()
    {
        
        
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

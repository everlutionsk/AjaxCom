<?php

namespace DM\AjaxCom\Responder;

class Modal extends AbstractResponder
{
    const OBJECT_IDENTIFIER = 'modal';
    
    const OPTION_TYPE = 'type';
    
    
    private $title;
    private $width;
    private $height;
    

    /**
     * Constructor
     *
     * @param string $content
     */
    public function __construct()
    {
        $this->registerOption(self::OPTION_TYPE);
        $this->setOption(self::OPTION_TYPE, 'twitterbootstrap');
        return $this;
    }

    public function __call($method, $args) 
    {
        if (preg_match('#^(set|get)([a-zA-Z_]+)$#', $method, $matches)) {
            $property = strtolower($matches[2]);

            if (!property_exists($this, $property)) {
                throw new \Exception('Property '.$property.' cannot be set');
            }
            switch($matches[1]) {
                case 'set':
                    return $this->set($property, $args[0]);
                case 'get':
                    return $this->get($property);
            }
        }
    }
    
    public function get($property) {
        return $this->$property;
    }

    public function set($property, $value) {
        $this->$property = $value;
        return $this;
    }

    public function render()
    {
        return "xxssssxx".$this->getTitle();    
    }
}

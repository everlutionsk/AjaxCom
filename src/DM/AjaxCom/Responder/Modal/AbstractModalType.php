<?php

namespace DM\AjaxCom\Responder\Modal;

abstract class AbstractModalType
{
    
    protected $id;
    protected $title;
    protected $body;

    protected $width;
    protected $height;
    protected $buttons;
 
    
    public function __construct()
    {
        #set defaults
        $this->setId(uniqid('modal_'));
    }

   
    /**
     * Magic setters/getters for the defined properties
     * 
     * @var string $method 
     * @var array $args
     * @return mixed string/Object
     */
         
    public function __call($method, $args) 
    {
        if (preg_match('#^(set|get)([a-zA-Z_]+)$#', $method, $matches)) {
            $property = strtolower($matches[2]);

            if (!property_exists($this, $property)) {
                throw new \Exception('Property '.$property.' cannot be set');
            }
            switch ($matches[1]) {
                case 'set':
                    return $this->set($property, $args[0]);
                case 'get':
                    return $this->get($property);
            }
        }
    }
    
    /**
     * Gets property value
     * 
     * @var string $property 
     * @return mixed value
     */
    private function get($property) {
        return $this->$property;
    }

    /**
     * Sets property value
     *
     * @var string $property
     * @var mixed $value
     * @return object AbstractModalType
     */
    private function set($property, $value) {
        $this->$property = $value;
        return $this;
    }

    /**
     * Get Html
     *
     */ 
    public abstract function getHtml();
    
}

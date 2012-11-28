<?php

namespace DM\AjaxCom\Responder\Container;

use DM\AjaxCom\Responder\ResponderInterface;

class Container implements ResponderInterface
{
    /**
     * Constructor
     *
     * @param string $identifier
     */
    public function __construct($identifier = null)
    {
    }
}

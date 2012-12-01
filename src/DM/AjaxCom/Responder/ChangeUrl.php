<?php

namespace DM\AjaxCom\Responder;

use DM\AjaxCom\Responder\ResponseObjectAbstract;

class ChangeUrl extends ResponseObjectAbstract
{

    const OBJECT_IDENTIFIER = 'changeurl';

    const OPTION_URL = 'url';
    const OPTION_WAIT = 'wait';


    /**
     * Constructor
     *
     * @param string $url
     * @param int $wait
     */
    
    public function __construct($url, $wait = 0)
    {
     
        $this->registerOption(self::OPTION_URL);
        $this->registerOption(self::OPTION_WAIT);

        $this->setOption(self::OPTION_URL, $url);
        $this->setOption(self::OPTION_WAIT, $wait);
    }
}

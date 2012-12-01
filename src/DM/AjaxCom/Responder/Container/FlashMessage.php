<?php

namespace DM\AjaxCom\Responder\Container;

class FlashMessage extends Container
{
    const TYPE_SUCCESS = 'success';
    const TYPE_INFO = 'info';
    const TYPE_ERROR = 'error';

    const OPTION_TYPE = 'type';

    private static $flashMessageContainer = '[data-ajaxcom-flashmessage]';


    public function __construct($message, $type = self::TYPE_SUCCESS)
    {
        parent::__construct();
        $this->registerOption(self::OPTION_TYPE);

        $this->setOption(self::OPTION_TYPE, $type);
        $this->setOption(self::OPTION_TARGET, $this::$flashMessageContainer);

        $this->append($message);
    }
}

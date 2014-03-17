<?php

namespace DM\AjaxCom\Responder\Container;

class FlashMessage extends Container
{
    const TYPE_SUCCESS = 'success';
    const TYPE_INFO = 'info';
    const TYPE_ERROR = 'error';
    const METHOD_APPEND = 'append';
    const METHOD_REPLACE = 'replace';

    const OPTION_TYPE = 'type';

    private static $template = '<div class="%type%">%value%</div>';

    private static $container = '[data-ajaxcom-flashmessage]';

    public function __construct($message, $type = self::TYPE_SUCCESS, $method = self::METHOD_APPEND)
    {
        parent::__construct();
        $this->registerOption(self::OPTION_TYPE);

        $this->setOption(self::OPTION_TYPE, $type);
        $this->setOption(self::OPTION_TARGET, $this::$container);

        $value = $this::$template;
        $value = str_replace('%type%', $type, $value);
        $value = str_replace('%value%', $message, $value);

        if ($method == self::METHOD_APPEND) {
            $this->append($value);
        } else {
            $this->html($value);
        }
    }
}

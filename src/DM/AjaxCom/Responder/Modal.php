<?php

namespace DM\AjaxCom\Responder;

class Modal extends AbstractResponder
{
    const OBJECT_IDENTIFIER = 'modal';

    const OPTION_TYPE = 'type';
    const OPTION_HTML = 'html';
    const OPTION_CLOSE = 'close';
    const OPTION_AUTOREMOVE = 'autoremove';

    const DEFAULT_TYPE = 'twitterbootstrap';

    /**
     * Constructor
     *
     * @param string $html HTML for a new modal or a jquery selector for an
     *                     existing modal
     * @param string $type Type of modal to create
     * @param bool $autoremove Remove the modal from the dom when it is closed
     */
    public function __construct($html, $type = self::DEFAULT_TYPE, $autoremove = true)
    {
        $this->registerOption(self::OPTION_HTML);
        $this->registerOption(self::OPTION_TYPE);
        $this->registerOption(self::OPTION_CLOSE);
        $this->registerOption(self::OPTION_AUTOREMOVE);

        $this->setOption(self::OPTION_HTML, $html);
        $this->setOption(self::OPTION_TYPE, $type);
        $this->setOption(self::OPTION_AUTOREMOVE, (bool)$autoremove);
    }

    /**
     * Close modal
     *
     * @return Modal
     */
    public function close()
    {
        $this->setOption(self::OPTION_CLOSE, true);

        return $this;
    }
}

<?php

namespace DM\AjaxCom;

use Responder\ResponderInterface;
use Responder\Container\FlashMessage;
use Responder\Container\Container;
use Responder\Modal;

class Handler
{
    /**
     * Collection of ResponderInterface objects
     *
     * @var array $queue
     */
    private $queue = array();

    /**
     * Add ResponderInterface object to the queue
     *
     * @var ResponderInterface $responder
     * @return Handler
     */
    public function register(ResponderInterface $responder)
    {
        return $this;
    }

    /**
     * Remove ResponderInterface object from the queue
     *
     * @var ResponderInterface $responder
     * @return Handler
     */
    public function unregister(ResponderInterface $responder)
    {
        return $this;
    }

    /**
     * Create a FlashMessage and register it to the queue
     *
     * Convenience method to allow for a fluent interface
     *
     * @var string $message
     * @var string $type
     * @return FlashMessage
     */
    public function flashMessage($message, $type = FlashMessage::SUCCESS)
    {
    }

    /**
     * Create a Container and register it to the queue
     *
     * Convenience method to allow for a fluent interface
     *
     * @var string $identifier
     * @return Container
     */
    public function container($identifier)
    {
    }

    /**
     * Create a Modal and register it to the queue
     *
     * Convenience method to allow for a fluent interface
     *
     * @return Modal
     */
    public function modal()
    {
    }

    /**
     * Create a Callback and register it to the queue
     *
     * Convenience method to allow for a fluent interface
     *
     * @var string $function
     * @return Callback
     */
    public function callback($function)
    {
    }

    /**
     * Create a ChangeUrl and register it to the queue
     *
     * Convenience method to allow for a fluent interface
     *
     * @var string $url
     * @return ChangeUrl
     */
    public function changeUrl($url)
    {
    }
}

<?php

namespace DM\AjaxCom\Responder\Container;

use DM\AjaxCom\Responder\AbstractResponder;

class Container extends AbstractResponder
{
    const OBJECT_IDENTIFIER = 'container';

    const OPTION_VALUE = 'value';
    const OPTION_TARGET = 'target';
    const OPTION_METHOD = 'method';
    const OPTION_ANIMATE = 'animate';
    const OPTION_REMOVE_CLASS = 'removeClass';
    const OPTION_ADD_CLASS = 'addClass';
    const OPTION_ATTR = 'attr';

    /**
     * Constructor
     *
     * @param string $identifier
     */
    public function __construct($identifier = null)
    {
        $this->registerOption(self::OPTION_VALUE);
        $this->registerOption(self::OPTION_TARGET);
        $this->registerOption(self::OPTION_METHOD);
        $this->registerOption(self::OPTION_ANIMATE);
        $this->registerOption(self::OPTION_REMOVE_CLASS);
        $this->registerOption(self::OPTION_ADD_CLASS);
        $this->registerOption(self::OPTION_ATTR);


        if ($identifier) {
            $this->setOption(self::OPTION_TARGET, $identifier);
        }

        $this->animate();
    }

    /**
     * Append html to container
     *
     * @var string $html
     * @return Container
     */

    public function append($html)
    {
        $this->setOption(self::OPTION_VALUE, $html);
        $this->setOption(self::OPTION_METHOD, 'append');

        return $this;
    }

    /**
     * Prepend html to container
     *
     * @var string $html
     * @return Container
     */
    public function prepend($html)
    {
        $this->setOption(self::OPTION_VALUE, $html);
        $this->setOption(self::OPTION_METHOD, 'prepend');

        return $this;
    }

    /**
     * Replace container html with this html
     *
     * @var string $html
     * @return Container
     */
    public function replaceWith($html)
    {
        $this->setOption(self::OPTION_VALUE, $html);
        $this->setOption(self::OPTION_METHOD, 'replaceWith');

        return $this;
    }

    /**
     * Sets inner html of container
     *
     * @var string $html
     * @return Container
     */
    public function html($html)
    {
        $this->setOption(self::OPTION_VALUE, $html);
        $this->setOption(self::OPTION_METHOD, 'html');

        return $this;
    }

    /**
     * Set value of container object
     *
     * @var string $html
     * @return Container
     */
    public function val($html)
    {
        $this->setOption(self::OPTION_VALUE, $html);
        $this->setOption(self::OPTION_METHOD, 'val');

        return $this;
    }

    /**
     * Remove container
     *
     * @return Container
     */
    public function remove()
    {
        $this->setOption(self::OPTION_METHOD, 'remove');

        return $this;
    }


    /**
     * Enable/disable animation effect
     *
     * @var bool $enable
     * @return Container
     */
    public function animate($enable = false)
    {
        $this->setOption(self::OPTION_ANIMATE, (bool)$enable);

        return $this;
    }

    /**
     * Remove CSS class from container
     *
     * @param string $class
     * @return Container
     */
    public function removeClass($class)
    {
        $this->setOption(self::OPTION_METHOD, "removeClass");
        $this->setOption(self::OPTION_REMOVE_CLASS, $class);

        return $this;
    }

    /**
     * Add CSS class to container
     *
     * @param string $class
     * @return Container
     */
    public function addClass($class)
    {
        $this->setOption(self::OPTION_METHOD, "addClass");
        $this->setOption(self::OPTION_ADD_CLASS, $class);

        return $this;
    }

    /**
     * Changes attribute value of container
     *
     * @param $attribute
     * @param null $value
     * @return $this
     */
    public function attr($attribute, $value)
    {
        $this->setOption(self::OPTION_METHOD, "attr");
        $this->setOption(self::OPTION_ATTR, $attribute);
        $this->setOption(self::OPTION_VALUE, $value);

        return $this;
    }
}

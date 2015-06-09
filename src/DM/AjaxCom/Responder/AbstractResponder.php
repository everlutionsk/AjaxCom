<?php

namespace DM\AjaxCom\Responder;

abstract class AbstractResponder implements ResponderInterface
{
    const OBJECT_IDENTIFIER = null;

    /**
     * @var array validOptions - container holding valid options for the responseObject
     */
    private $validOptions = array();

    /**
     * @var array
     */
    private $options = array();

    /**
     * Sets value to the option of the operation
     *
     * @var string $option
     * @var string $value
     * @return ResponderInterface
     */
    public function setOption($option, $value)
    {
        if ($this->isValidOption($option)) {
            $this->options[$option] = $value;
        }

        return $this;
    }

    /**
     * Sets values to the options of the operation
     *
     * @var array $option
     * @return ResponderInterface
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            if ($this->isValidOption($key)) {
                $this->options[$key] = $value;
            }
        }

        return $this;
    }

    /**
     * Gets all options of the operation
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Gets value from options
     *
     * @var string $option
     * @return string value
     * @throws \Exception
     */
    public function getOption($option)
    {
        if (!isset($this->options[$option])) {
            throw new \Exception('This option does not exist');
        }

        return $this->options[$option];
    }

    /**
     * Validates a option comparing it to the registered options of the responseobject
     *
     * @var array $option
     * @return bool
     * @throws \Exception
     */
    private function isValidOption($option)
    {
        if (!in_array($option, $this->validOptions)) {
            throw new \Exception('Not a valid option type for this component');
        }

        return true;
    }

    /**
     * registers an option from the response object
     *
     * @var array $option
     * @return ResponderInterface
     */
    protected function registerOption($option)
    {
        if (!in_array($option, $this->validOptions)) {
            array_push($this->validOptions, $option);
        }

        return $this;
    }


    /**
     * Render the operation item
     * @return string operation item
     * @throws \Exception
     */
    public function render()
    {
        if (!$this::OBJECT_IDENTIFIER) {
            throw new \Exception('No operation was set');
        }

        $operation = array(
            'operation' => $this::OBJECT_IDENTIFIER,
            'options' => $this->options
        );

        return $operation;
    }
}

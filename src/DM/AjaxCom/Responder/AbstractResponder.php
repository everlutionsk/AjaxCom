<?php

namespace DM\AjaxCom\Responder;

use DM\AjaxCom\Responder\ResponderInterface;

abstract class AbstractResponder implements ResponderInterface
{

    const OBJECT_IDENTIFIER = null;

    /**
     * @var array validOptions - container holding valid options for the responseObject
     */
    private $validOptions = array();

    /**
     * @var string operation - identifier of the object
     */
    private $operation = null;

    private $options = array();


    /**
     * Sets value to the option of the operation
     *
     * @var string $option
     * @var string $value
     * @return ResponseObject
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
     * @return ResponseObject
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
     * @return boolean
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
     * @return ResponseObject
     */
    protected function registerOption($option)
    {
        if (!in_array($option, $this->validOptions)) {
            array_push($this->validOptions, $option);
        }
        return $this;
    }



    /**
     * Render the opperation item
     *
     * @return opperation item
     */
    public function render()
    {
        if (!$this::OBJECT_IDENTIFIER) {
            throw new \Exception('No operation was set');
        }

        $operation = array( 'operation' => $this::OBJECT_IDENTIFIER,
                            'options' => $this->options
                        );

        return $operation;
    }
}

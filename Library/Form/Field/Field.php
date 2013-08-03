<?php
/**
 * Created by Aurelien
 * Date: 04/07/13
 * Time: 14:30
 */

namespace Library\Form\Field;


abstract class Field
{
    private $errorMessage;
    private $label;
    private $name;
    private $validators = array();
    private $value;
    private $length;

    public function __construct(array $options = array())
    {
        if (!empty($options))
        {
            $this->hydrate($options);
        }
    }

    abstract public function buildWidget();

    public function hydrate($options)
    {
        foreach ($options as $type => $value)
        {
            $method = 'set'.ucfirst($type);

            if (is_callable(array($this, $method)))
            {
                $this->$method($value);
            }
        }
    }

    public function isValid()
    {
        foreach ($this->validators as $validator)
        {
            if (!$validator->isValid($this->value))
            {
                $this->errorMessage = $validator->errorMessage();
                return false;
            }
        }

        return true;
    }

    public function hasErrorMessage()
    {
        return !empty($this->errorMessage);
    }

    public function errorMessage(){
        return $this->errorMessage;
    }

    public function setErrorMessage($message)
    {
        $this->errorMessage = $message;
    }

    public function label()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        if (is_string($label))
        {
            $this->label = $label;
        }
    }

    public function length()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        $length = (int) $length;

        if ($length > 0)
        {
            $this->length = $length;
        }
    }

    public function name()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if (is_string($name))
        {
            $this->name = $name;
        }
    }

    public function validators()
    {
        return $this->validators;
    }

    public function setValidators(array $validators)
    {
        foreach ($validators as $validator)
        {
            if ($validator instanceof Validator && !in_array($validator, $this->validators))
            {
                $this->validators[] = $validator;
            }
        }
    }

    public function hasValue()
    {
        return !empty($this->value);
    }

    public function value()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        if (is_string($value))
        {
            $this->value = $value;
        }
    }
}
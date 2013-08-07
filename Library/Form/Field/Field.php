<?php
/**
 * Created by Aurelien
 * Date: 04/07/13
 * Time: 14:30
 */

namespace Library\Form\Field;


use Library\Form\Validator\Validator;

/**
 * Field
 *
 * @package Library\Form\Field
 * @author Aurelien Mecheri
 * @abstract
 */
abstract class Field{
    /**
     * @access private
     * @var string $_label
     */
    private $_label;
    /**
     * @access private
     * @var string $_name
     */
    private $_name;
    /**
     * @access private
     * @var string $_value
     */
    private $_value;
    /**
     * @access private
     * @var string $_classes
     */
    private $_classes;
    /**
     * @access private
     * @var array $_validators
     */
    private $_validators = array();
    /**
     * @access private
     * @var string $_errorMessage
     */
    private $_errorMessage;

    /**
     * Construct with hydrate attributes
     *
     * @param array $options
     */
    public function __construct(array $options = array()){
        if (!empty($options)){
            $this->hydrate($options);
        }
    }

    /**
     * Builder
     *
     * @abstract
     */
    abstract public function buildWidget();

    /**
     * Hydrate
     *
     * @param array $options
     */
    public function hydrate(array $options){
        foreach ($options as $type => $value){
            $method = 'set'.ucfirst($type);
            if (is_callable(array($this, $method))){
                $this->$method($value);
            }
        }
    }

    /**
     * Check if value respects validators
     *
     * @return bool
     */
    public function isValid(){
        foreach ($this->_validators as $validator){
            if (!$validator->isValid($this->_value)){
                $this->setErrorMessage($validator->errorMessage());
                return false;
            }
        }
        return true;
    }

    /**
     * Getter $_label
     *
     * @return string $_label
     */
    public function label(){
        return $this->_label;
    }

    /**
     * Setter $_label
     *
     * @param string $label
     */
    public function setLabel($label){
        if (is_string($label)){
            $this->_label = $label;
        }
    }

    /**
     * Getter $_name
     *
     * @return string $_name
     */
    public function name(){
        return $this->_name;
    }

    /**
     * Setter $_name
     *
     * @param string $name
     */
    public function setName($name){
        if (is_string($name))
        {
            $this->_name = $name;
        }
    }

    /**
     * Check if $_value is not empty
     *
     * @return bool
     */
    public function hasValue(){
        return !empty($this->_value);
    }

    /**
     * Getter $_value
     *
     * @return string $_value
     */
    public function value(){
        return $this->_value;
    }

    /**
     * Setter $_value
     *
     * @param string $value
     */
    public function setValue($value){
        if (is_string($value)){
            $this->_value = $value;
        }
    }

    /**
     * Getter $_classes
     *
     * @return string $_classes
     */
    public function classes(){
        return $this->_classes;
    }

    /**
     * Setter $_classes
     *
     * @param string $classes
     */
    public function setClasses($classes){
        if (is_string($classes)){
            $this->_classes = $classes;
        }
    }

    /**
     * Getter $_validators
     *
     * @return array $_validators
     */
    public function validators(){
        return $this->_validators;
    }

    /**
     * Setter $_validators
     *
     * @param array $validators
     */
    public function setValidators(array $validators){
        foreach ($validators as $validator){
            if ($validator instanceof Validator && !in_array($validator, $this->_validators)){
                $this->_validators[] = $validator;
            }
        }
    }

    /**
     * Check if $_errorMessage is not empty
     *
     * @return bool
     */
    public function hasErrorMessage(){
        return !empty($this->_errorMessage);
    }

    /**
     * Getter $_errorMessage
     *
     * @return string $_errorMessage
     */
    public function errorMessage(){
        return $this->_errorMessage;
    }

    /**
     * Setter $_errorMessage
     *
     * @param string $message
     */
    public function setErrorMessage($message){
        $this->_errorMessage = $message;
    }
}
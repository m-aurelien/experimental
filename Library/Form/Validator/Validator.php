<?php
/**
 * Created by Aurelien
 * Date: 04/07/13
 * Time: 14:37
 */

namespace Library\Form\Validator;

/**
 * Validator
 *
 * @package Library\Form\Validator
 * @author Aurelien Mecheri
 * @abstract
 */
abstract class Validator{
    /**
     * @access private
     * @var string $_errorMessage
     */
    private $_errorMessage;

    /**
     * Construct that set $_errorMessage
     *
     * @param $errorMessage
     */
    public function __construct($errorMessage){
        $this->setErrorMessage($errorMessage);
    }

    /**
     * Check if value is valid
     * @param $value
     * @abstract
     */
    abstract public function isValid($value);

    /**
     * Setter $_errorMessage
     *
     * @param string $errorMessage
     */
    public function setErrorMessage($errorMessage){
        if (is_string($errorMessage)){
            $this->_errorMessage = $errorMessage;
        }
    }

    /**
     * Getter $_errorMessage
     *
     * @return string $_errorMessage
     */
    public function errorMessage(){
        return $this->_errorMessage;
    }
}
<?php
/**
 * Created by Aurelien
 * Date: 04/07/13
 * Time: 14:38
 */

namespace Library\Form\Validator;

/**
 * MaxLengthValidator
 *
 * @package Library\Form\Validator
 * @author Aurelien Mecheri
 */
class MaxLengthValidator extends Validator{
    /**
     * @access private
     * @var int $_maxLength
     */
    private $_maxLength;

    /**
     * Construct that set $_errorMessage and $_maxLength
     *
     * @param string $errorMessage
     * @param int $maxLength
     */
    public function __construct($errorMessage, $maxLength){
        parent::__construct($errorMessage);

        $this->setMaxLength($maxLength);
    }

    /**
     * Check if value is lower or equal to $_maxLength
     *
     * @param $value
     * @return bool
     */
    public function isValid($value){
        return strlen($value) <= $this->_maxLength;
    }

    /**
     * Setter $_maxLength
     *
     * @param int $maxLength
     * @throws \RuntimeException
     */
    public function setMaxLength($maxLength){
        $maxLength = (int) $maxLength;

        if ($maxLength > 0){
            $this->_maxLength = $maxLength;
        }else{
            throw new \RuntimeException('La longueur maximale doit être un nombre supérieur à 0');
        }
    }
}
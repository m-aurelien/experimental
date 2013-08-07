<?php
/**
 * Created by Aurelien
 * Date: 04/07/13
 * Time: 14:37
 */

namespace Library\Form\Validator;

/**
 * NotNullValidator
 *
 * @package Library\Form\Validator
 * @author Aurelien Mecheri
 */
class NotNullValidator extends Validator{
    /**
     * Check if value is not null
     *
     * @param $value
     * @return bool
     */
    public function isValid($value){
        return $value != '';
    }
}
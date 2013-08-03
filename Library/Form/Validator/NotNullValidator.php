<?php
/**
 * Created by Aurelien
 * Date: 04/07/13
 * Time: 14:37
 */

namespace Library\Form\Validator;


class NotNullValidator extends Validator
{
    public function isValid($value)
    {
        return $value != '';
    }
}
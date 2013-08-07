<?php
/**
 * Created by Aurelien
 * Date: 04/07/13
 * Time: 14:31
 */

namespace Library\Form\Field;


/**
 * PasswordField
 *
 * @package Library\Form\Field
 * @author Aurelien Mecheri
 */
class PasswordField extends Field{
    /**
     * @access private
     * @var
     */
    private $_maxLength;

    /**
     * Builder
     *
     * @return string
     */
    public function buildWidget(){
        $widget = '';

        if($this->label()) $widget  = '<label>'.$this->label().'</label>';

        $widget .= '<input type="password" name="'.$this->name().'"';
        if ($this->hasValue()) $widget .= ' value="'.htmlspecialchars($this->value()).'"';
        if (!empty($this->_maxLength)) $widget .= ' maxlength="'.$this->_maxLength.'"';
        $widget .= ' />';

        if ($this->hasErrorMessage()) $widget .= '<p>'.$this->errorMessage().'</p>';

        return $widget;
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